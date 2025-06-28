<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Services\InvoiceService;
use App\Repositories\InvoiceRepository;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceService;
    protected $invoiceRepository;

    public function __construct(InvoiceService $invoiceService, InvoiceRepository $invoiceRepository)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'client_id', 'project_id', 'date_from', 'date_to', 'search']);
        $invoices = $this->invoiceRepository->getPaginated(15, $filters);
        $statistics = $this->invoiceRepository->getStatistics();
        
        $clients = Client::where('status', 'active')->get();
        $projects = Project::all();
        
        return view('invoices.index', compact('invoices', 'statistics', 'clients', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('status', 'active')->get();
        $projects = Project::all();
        return view('invoices.create', compact('clients', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        try {
            $invoice = $this->invoiceService->createInvoice($request->validated());
            
            return redirect()->route('invoices.index')
                ->with('success', 'Invoice berhasil dibuat dengan nomor: ' . $invoice->invoice_number);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = $this->invoiceRepository->findWithRelations($invoice->id);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::where('status', 'active')->get();
        $projects = Project::all();
        return view('invoices.edit', compact('invoice', 'clients', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        try {
            $updatedInvoice = $this->invoiceService->updateInvoice($invoice, $request->validated());
            
            return redirect()->route('invoices.show', $updatedInvoice)
                ->with('success', 'Invoice berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    /**
     * Download PDF of the specified invoice.
     */
    public function downloadPdf(Invoice $invoice)
    {
        return $this->invoiceService->generatePdf($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }
}
