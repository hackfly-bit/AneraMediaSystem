<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Mail\InvoiceCreated;
use App\Mail\InvoiceOverdue;
use App\Mail\InvoicePaymentReceived;
use App\Mail\InvoiceReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Invoice $invoice,
        public string $emailType,
        public ?string $recipientEmail = null
    ) {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $recipient = $this->recipientEmail ?? $this->invoice->client->email;
            
            if (!$recipient) {
                Log::warning('No email address found for invoice', [
                    'invoice_id' => $this->invoice->id,
                    'client_id' => $this->invoice->client_id
                ]);
                return;
            }

            $mailable = $this->getMailable();
            
            if ($mailable) {
                Mail::to($recipient)->send($mailable);
                
                Log::info('Invoice email sent successfully', [
                    'invoice_id' => $this->invoice->id,
                    'email_type' => $this->emailType,
                    'recipient' => $recipient
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send invoice email', [
                'invoice_id' => $this->invoice->id,
                'email_type' => $this->emailType,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get the appropriate mailable based on email type
     */
    private function getMailable()
    {
        return match ($this->emailType) {
            'created' => new InvoiceCreated($this->invoice),
            'reminder' => new InvoiceReminder($this->invoice),
            'overdue' => new InvoiceOverdue($this->invoice),
            'payment_received' => new InvoicePaymentReceived($this->invoice),
            default => null
        };
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Invoice email job failed permanently', [
            'invoice_id' => $this->invoice->id,
            'email_type' => $this->emailType,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
    }
}