<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InvoiceService
{
    /**
     * Create a new invoice with items
     */
    public function createInvoice(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            // Generate invoice number if not provided
            if (!isset($data['invoice_number'])) {
                $data['invoice_number'] = $this->generateInvoiceNumber();
            }

            // Calculate amounts
            $data = $this->calculateAmounts($data);

            // Create invoice
            $invoice = Invoice::create([
                'client_id' => $data['client_id'],
                'project_id' => $data['project_id'] ?? null,
                'invoice_number' => $data['invoice_number'],
                'amount' => $data['amount'],
                'tax_amount' => $data['tax_amount'] ?? 0,
                'total_amount' => $data['total_amount'],
                'status' => $data['status'] ?? 'pending',
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'paid_date' => $data['paid_date'] ?? null,
                'notes' => $data['notes'] ?? null,
                'payment_percentage' => $data['payment_percentage'] ?? 100,
                'payment_sequence' => $data['payment_sequence'] ?? 1,
            ]);

            // Create invoice items if provided
            if (isset($data['items']) && is_array($data['items'])) {
                $this->createInvoiceItems($invoice, $data['items']);
            }

            Log::info('Invoice created', ['invoice_id' => $invoice->id, 'invoice_number' => $invoice->invoice_number]);

            return $invoice->load(['client', 'project', 'invoiceItems']);
        });
    }

    /**
     * Update an existing invoice
     */
    public function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            // Calculate amounts
            $data = $this->calculateAmounts($data);

            // Update invoice
            $invoice->update([
                'client_id' => $data['client_id'],
                'project_id' => $data['project_id'] ?? null,
                'invoice_number' => $data['invoice_number'],
                'amount' => $data['amount'],
                'tax_amount' => $data['tax_amount'] ?? 0,
                'total_amount' => $data['total_amount'],
                'status' => $data['status'],
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'paid_date' => $data['paid_date'] ?? null,
                'notes' => $data['notes'] ?? null,
                'payment_percentage' => $data['payment_percentage'] ?? $invoice->payment_percentage,
                'payment_sequence' => $data['payment_sequence'] ?? $invoice->payment_sequence,
            ]);

            // Update invoice items if provided
            if (isset($data['items']) && is_array($data['items'])) {
                // Delete existing items
                $invoice->invoiceItems()->delete();
                // Create new items
                $this->createInvoiceItems($invoice, $data['items']);
            }

            Log::info('Invoice updated', ['invoice_id' => $invoice->id, 'invoice_number' => $invoice->invoice_number]);

            return $invoice->load(['client', 'project', 'invoiceItems']);
        });
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(Invoice $invoice, ?string $paidDate = null): Invoice
    {
        $invoice->update([
            'status' => 'paid',
            'paid_date' => $paidDate ? Carbon::parse($paidDate) : now(),
        ]);

        Log::info('Invoice marked as paid', ['invoice_id' => $invoice->id]);

        return $invoice;
    }

    /**
     * Generate unique invoice number
     */
    public function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');

        // Get the last invoice number for this month
        $lastInvoice = Invoice::where('invoice_number', 'like', "{$prefix}-{$year}{$month}-%")
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $newNumber);
    }

    /**
     * Calculate invoice amounts
     */
    private function calculateAmounts(array $data): array
    {
        $amount = $data['amount'] ?? 0;
        $taxRate = $data['tax_rate'] ?? 0;
        $taxAmount = $amount * ($taxRate / 100);
        $totalAmount = $amount + $taxAmount;

        $data['tax_amount'] = $taxAmount;
        $data['total_amount'] = $totalAmount;

        return $data;
    }

    /**
     * Create invoice items
     */
    private function createInvoiceItems(Invoice $invoice, array $items): void
    {
        foreach ($items as $item) {
            $totalPrice = $item['quantity'] * $item['unit_price'];

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $totalPrice,
            ]);
        }
    }

    /**
     * Get invoice statistics
     */
    public function getInvoiceStatistics(): array
    {
        return [
            'total_invoices' => Invoice::count(),
            'pending_invoices' => Invoice::where('status', 'pending')->count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
            'total_amount' => Invoice::sum('total_amount'),
            'paid_amount' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending_amount' => Invoice::where('status', 'pending')->sum('total_amount'),
        ];
    }

    /**
     * Generate PDF for invoice
     */
    public function generatePdf(Invoice $invoice)
    {
        $invoice->load(['client', 'project', 'invoiceItems']);

        $pdf = \PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Create multiple invoices for project with percentage payments
     */
    public function createProjectInvoices(Project $project, array $paymentSchedule): array
    {
        $invoices = [];
        $totalBudget = $project->budget;

        foreach ($paymentSchedule as $index => $payment) {
            $amount = $totalBudget * ($payment['percentage'] / 100);

            $invoiceData = [
                'client_id' => $project->client_id,
                'project_id' => $project->id,
                'amount' => $amount,
                'issue_date' => $payment['issue_date'],
                'due_date' => $payment['due_date'],
                'payment_percentage' => $payment['percentage'],
                'payment_sequence' => $index + 1,
                'notes' => $payment['notes'] ?? "Pembayaran ke-" . ($index + 1) . " untuk proyek {$project->name}",
            ];

            $invoices[] = $this->createInvoice($invoiceData);
        }

        return $invoices;
    }
}
