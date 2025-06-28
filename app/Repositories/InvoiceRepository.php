<?php

namespace App\Repositories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceRepository
{
    /**
     * Get paginated invoices with relationships
     */
    public function getPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Invoice::with(['client', 'project', 'invoiceItems'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (isset($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (isset($filters['date_from'])) {
            $query->where('issue_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('issue_date', '<=', $filters['date_to']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('company', 'like', "%{$search}%");
                  })
                  ->orWhereHas('project', function ($projectQuery) use ($search) {
                      $projectQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get invoice by ID with relationships
     */
    public function findWithRelations(int $id): ?Invoice
    {
        return Invoice::with(['client', 'project', 'invoiceItems'])->find($id);
    }

    /**
     * Get overdue invoices
     */
    public function getOverdueInvoices(): Collection
    {
        return Invoice::with(['client', 'project'])
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->get();
    }

    /**
     * Get invoices by status
     */
    public function getByStatus(string $status): Collection
    {
        return Invoice::with(['client', 'project'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get invoices by client
     */
    public function getByClient(int $clientId): Collection
    {
        return Invoice::with(['project', 'invoiceItems'])
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get invoices by project
     */
    public function getByProject(int $projectId): Collection
    {
        return Invoice::with(['client', 'invoiceItems'])
            ->where('project_id', $projectId)
            ->orderBy('payment_sequence', 'asc')
            ->get();
    }

    /**
     * Get invoice statistics
     */
    public function getStatistics(): array
    {
        return [
            'total_count' => Invoice::count(),
            'pending_count' => Invoice::where('status', 'pending')->count(),
            'paid_count' => Invoice::where('status', 'paid')->count(),
            'overdue_count' => Invoice::where('status', 'overdue')->count(),
            'total_amount' => Invoice::sum('total_amount'),
            'paid_amount' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending_amount' => Invoice::where('status', 'pending')->sum('total_amount'),
            'overdue_amount' => Invoice::where('status', 'overdue')->sum('total_amount'),
        ];
    }

    /**
     * Get monthly revenue data
     */
    public function getMonthlyRevenue(int $year): array
    {
        return Invoice::select(
                DB::raw('MONTH(issue_date) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'paid')
            ->whereYear('issue_date', $year)
            ->groupBy(DB::raw('MONTH(issue_date)'))
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
    }

    /**
     * Get top clients by revenue
     */
    public function getTopClientsByRevenue(int $limit = 10): Collection
    {
        return Invoice::select(
                'client_id',
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('COUNT(*) as invoice_count')
            )
            ->with('client')
            ->where('status', 'paid')
            ->groupBy('client_id')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent invoices
     */
    public function getRecent(int $limit = 5): Collection
    {
        return Invoice::with(['client', 'project'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Search invoices
     */
    public function search(string $query, int $limit = 20): Collection
    {
        return Invoice::with(['client', 'project'])
            ->where('invoice_number', 'like', "%{$query}%")
            ->orWhereHas('client', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('company', 'like', "%{$query}%");
            })
            ->orWhereHas('project', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Update invoice status to overdue for past due invoices
     */
    public function updateOverdueInvoices(): int
    {
        return Invoice::where('status', 'pending')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);
    }

    /**
     * Get invoices due in X days
     */
    public function getDueSoon(int $days = 7): Collection
    {
        return Invoice::with(['client', 'project'])
            ->where('status', 'pending')
            ->whereBetween('due_date', [now(), now()->addDays($days)])
            ->orderBy('due_date', 'asc')
            ->get();
    }
}