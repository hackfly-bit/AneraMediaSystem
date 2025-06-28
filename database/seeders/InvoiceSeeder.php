<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Invoice dengan pembayaran penuh (100%)
        $invoice1 = Invoice::create([
            'client_id' => 1,
            'project_id' => 1,
            'invoice_number' => 'INV-2025-001',
            'amount' => 37500000.00,
            'tax_amount' => 4125000.00,
            'total_amount' => 41625000.00,
            'currency' => 'IDR',
            'status' => 'paid',
            'issue_date' => '2025-01-15',
            'due_date' => '2025-02-14',
            'paid_date' => '2025-02-10',
            'payment_percentage' => 100.00,
            'payment_sequence' => 1,
            'notes' => 'Pembayaran penuh untuk pengembangan website e-commerce'
        ]);

        // Invoice dengan pembayaran bertahap - tahap 1 (50%)
        $invoice2 = Invoice::create([
            'client_id' => 2,
            'project_id' => 2,
            'invoice_number' => 'INV-2025-002',
            'amount' => 25000000.00,
            'tax_amount' => 2750000.00,
            'total_amount' => 27750000.00,
            'currency' => 'IDR',
            'status' => 'paid',
            'issue_date' => '2024-12-20',
            'due_date' => '2025-01-19',
            'paid_date' => '2025-01-15',
            'payment_percentage' => 50.00,
            'payment_sequence' => 1,
            'notes' => 'Pembayaran ke-1 (50%) untuk kampanye digital marketing'
        ]);

        // Invoice dengan pembayaran bertahap - tahap 2 (50%)
        $invoice3 = Invoice::create([
            'client_id' => 2,
            'project_id' => 2,
            'invoice_number' => 'INV-2025-003',
            'amount' => 25000000.00,
            'tax_amount' => 2750000.00,
            'total_amount' => 27750000.00,
            'currency' => 'IDR',
            'status' => 'pending',
            'issue_date' => '2025-02-15',
            'due_date' => '2025-03-17',
            'paid_date' => null,
            'payment_percentage' => 50.00,
            'payment_sequence' => 2,
            'notes' => 'Pembayaran ke-2 (50%) untuk kampanye digital marketing'
        ]);

        // Invoice dengan pembayaran custom (30%)
        $invoice4 = Invoice::create([
            'client_id' => 1,
            'project_id' => 4,
            'invoice_number' => 'INV-2025-004',
            'amount' => 22500000.00,
            'tax_amount' => 2475000.00,
            'total_amount' => 24975000.00,
             'currency' => 'IDR',
            'status' => 'overdue',
            'issue_date' => '2025-01-20',
            'due_date' => '2025-02-19',
            'paid_date' => null,
            'payment_percentage' => 30.00,
            'payment_sequence' => 1,
            'notes' => 'Pembayaran ke-1 (30%) untuk pengembangan aplikasi mobile'
        ]);

        // Create invoice items for each invoice
        $this->createInvoiceItems($invoice1, [
            ['description' => 'Analisis & Perencanaan Sistem', 'quantity' => 1, 'unit_price' => 7500000],
            ['description' => 'Desain UI/UX Website', 'quantity' => 1, 'unit_price' => 10000000],
            ['description' => 'Pengembangan Backend', 'quantity' => 1, 'unit_price' => 15000000],
            ['description' => 'Pengembangan Frontend', 'quantity' => 1, 'unit_price' => 5000000],
        ]);

        $this->createInvoiceItems($invoice2, [
            ['description' => 'Strategi Digital Marketing', 'quantity' => 1, 'unit_price' => 5000000],
            ['description' => 'Pembuatan Konten Kreatif', 'quantity' => 1, 'unit_price' => 8000000],
            ['description' => 'Setup Campaign Media Sosial', 'quantity' => 1, 'unit_price' => 7000000],
            ['description' => 'Optimasi SEO', 'quantity' => 1, 'unit_price' => 5000000],
        ]);

        $this->createInvoiceItems($invoice3, [
            ['description' => 'Implementasi Campaign', 'quantity' => 1, 'unit_price' => 10000000],
            ['description' => 'Monitoring & Analytics', 'quantity' => 1, 'unit_price' => 8000000],
            ['description' => 'Laporan & Optimasi', 'quantity' => 1, 'unit_price' => 7000000],
        ]);

        $this->createInvoiceItems($invoice4, [
            ['description' => 'Analisis Kebutuhan Mobile App', 'quantity' => 1, 'unit_price' => 5000000],
            ['description' => 'Desain Wireframe & Mockup', 'quantity' => 1, 'unit_price' => 7500000],
            ['description' => 'Setup Development Environment', 'quantity' => 1, 'unit_price' => 5000000],
            ['description' => 'Pengembangan MVP (Minimum Viable Product)', 'quantity' => 1, 'unit_price' => 5000000],
        ]);
    }

    /**
     * Create invoice items for an invoice
     */
    private function createInvoiceItems(Invoice $invoice, array $items): void
    {
        foreach ($items as $itemData) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $itemData['description'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'total_price' => $itemData['quantity'] * $itemData['unit_price'],
            ]);
        }
    }
}
