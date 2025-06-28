<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Services\InvoiceService;
use Livewire\Component;

class InvoicePreview extends Component
{
    public Invoice $invoice;
    public $showModal = false;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function openPreview()
    {
        $this->showModal = true;
    }

    public function closePreview()
    {
        $this->showModal = false;
    }

    public function downloadPdf()
    {
        $invoiceService = app(InvoiceService::class);
        return $invoiceService->generatePdf($this->invoice);
    }

    public function render()
    {
        return view('livewire.invoice-preview');
    }
}
