<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'project_id',
        'invoice_number',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
        'issue_date',
        'due_date',
        'paid_date',
        'notes',
        'payment_percentage',
        'payment_sequence',
        'currency',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_percentage' => 'decimal:2',
    ];

    /**
     * Get the client that owns the invoice.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the project that owns the invoice.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the invoice items for the invoice.
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the formatted total amount in Rupiah
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get the formatted amount in Rupiah
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get the status in Indonesian
     */
    public function getStatusIndonesianAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Tertunda',
            'paid' => 'Lunas',
            'overdue' => 'Terlambat',
            default => ucfirst($this->status)
        };
    }

    /**
     * Check if invoice is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }

    /**
     * Get days until due date
     */
    public function getDaysUntilDueAttribute(): int
    {
        return now()->diffInDays($this->due_date, false);
    }

    /**
     * Scope for pending invoices
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for paid invoices
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope for overdue invoices
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    /**
     * Scope for invoices due soon
     */
    public function scopeDueSoon($query, $days = 7)
    {
        return $query->where('status', 'pending')
                    ->whereBetween('due_date', [now(), now()->addDays($days)]);
    }
}
