<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any invoices.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'manager', 'accountant']);
    }

    /**
     * Determine whether the user can view the invoice.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        // Admin and manager can view all invoices
        if ($user->hasRole(['admin', 'manager'])) {
            return true;
        }

        // Accountant can view all invoices
        if ($user->hasRole('accountant')) {
            return true;
        }

        // User can only view their own invoices (if they are the client)
        return $invoice->client->user_id === $user->id;
    }

    /**
     * Determine whether the user can create invoices.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'manager', 'accountant']);
    }

    /**
     * Determine whether the user can update the invoice.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        // Admin can update all invoices
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can update invoices that are not paid
        if ($user->hasRole('manager')) {
            return $invoice->status !== 'paid';
        }

        // Accountant can only update payment status
        if ($user->hasRole('accountant')) {
            return in_array($invoice->status, ['pending', 'overdue']);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the invoice.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        // Only admin can delete invoices
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can delete unpaid invoices
        if ($user->hasRole('manager')) {
            return $invoice->status !== 'paid';
        }

        return false;
    }

    /**
     * Determine whether the user can restore the invoice.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the invoice.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can mark invoice as paid.
     */
    public function markAsPaid(User $user, Invoice $invoice): bool
    {
        return $user->hasRole(['admin', 'manager', 'accountant']) && 
               in_array($invoice->status, ['pending', 'overdue']);
    }

    /**
     * Determine whether the user can send invoice.
     */
    public function send(User $user, Invoice $invoice): bool
    {
        return $user->hasRole(['admin', 'manager', 'accountant']);
    }

    /**
     * Determine whether the user can download invoice PDF.
     */
    public function download(User $user, Invoice $invoice): bool
    {
        // Admin, manager, and accountant can download all invoices
        if ($user->hasRole(['admin', 'manager', 'accountant'])) {
            return true;
        }

        // Client can download their own invoices
        return $invoice->client->user_id === $user->id;
    }

    /**
     * Determine whether the user can view invoice statistics.
     */
    public function viewStatistics(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }
}