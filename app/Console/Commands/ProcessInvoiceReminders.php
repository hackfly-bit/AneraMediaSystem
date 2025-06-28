<?php

namespace App\Console\Commands;

use App\Jobs\SendInvoiceEmailJob;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessInvoiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:process-reminders {--dry-run : Show what would be processed without actually sending emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process invoice reminders and overdue notifications';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        
        $this->info('Memproses pengingat invoice...');
        
        // Process reminders (3 days before due date)
        $reminderInvoices = Invoice::with(['client', 'project'])
            ->where('status', 'pending')
            ->whereDate('due_date', '=', now()->addDays(3)->toDateString())
            ->get();
            
        $this->info("Ditemukan {$reminderInvoices->count()} invoice untuk pengingat.");
        
        foreach ($reminderInvoices as $invoice) {
            if ($isDryRun) {
                $this->line("[DRY RUN] Akan mengirim pengingat untuk invoice: {$invoice->invoice_number}");
            } else {
                SendInvoiceEmailJob::dispatch($invoice, 'reminder');
                $this->line("Pengingat dikirim untuk invoice: {$invoice->invoice_number}");
            }
        }
        
        // Process overdue invoices
        $overdueInvoices = Invoice::with(['client', 'project'])
            ->where('status', 'pending')
            ->whereDate('due_date', '<', now()->toDateString())
            ->get();
            
        $this->info("Ditemukan {$overdueInvoices->count()} invoice yang terlambat.");
        
        foreach ($overdueInvoices as $invoice) {
            if ($isDryRun) {
                $this->line("[DRY RUN] Akan mengupdate status dan mengirim notifikasi overdue untuk: {$invoice->invoice_number}");
            } else {
                // Update status to overdue
                $invoice->update(['status' => 'overdue']);
                
                // Send overdue notification
                SendInvoiceEmailJob::dispatch($invoice, 'overdue');
                
                $this->line("Status diupdate dan notifikasi dikirim untuk invoice: {$invoice->invoice_number}");
            }
        }
        
        // Process weekly overdue reminders (every Monday for invoices overdue > 7 days)
        if (now()->dayOfWeek === 1) { // Monday
            $weeklyOverdueInvoices = Invoice::with(['client', 'project'])
                ->where('status', 'overdue')
                ->whereDate('due_date', '<', now()->subDays(7)->toDateString())
                ->get();
                
            $this->info("Ditemukan {$weeklyOverdueInvoices->count()} invoice untuk pengingat mingguan.");
            
            foreach ($weeklyOverdueInvoices as $invoice) {
                if ($isDryRun) {
                    $this->line("[DRY RUN] Akan mengirim pengingat mingguan untuk: {$invoice->invoice_number}");
                } else {
                    SendInvoiceEmailJob::dispatch($invoice, 'overdue');
                    $this->line("Pengingat mingguan dikirim untuk invoice: {$invoice->invoice_number}");
                }
            }
        }
        
        $totalProcessed = $reminderInvoices->count() + $overdueInvoices->count();
        
        if ($isDryRun) {
            $this->info("[DRY RUN] Total {$totalProcessed} invoice akan diproses.");
        } else {
            $this->info("Selesai memproses {$totalProcessed} invoice.");
            
            Log::info('Invoice reminders processed', [
                'reminders_sent' => $reminderInvoices->count(),
                'overdue_processed' => $overdueInvoices->count(),
                'total_processed' => $totalProcessed
            ]);
        }
        
        return Command::SUCCESS;
    }
}