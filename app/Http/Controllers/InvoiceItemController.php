<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceItem;
use App\Models\Invoice;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Invoice $invoice)
    {
        $invoiceItems = $invoice->invoiceItems;
        return view('invoice-items.index', compact('invoice', 'invoiceItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Invoice $invoice)
    {
        return view('invoice-items.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ]);

        $validated['invoice_id'] = $invoice->id;
        InvoiceItem::create($validated);

        return redirect()->route('invoices.invoice-items.index', $invoice)
            ->with('success', 'Item invoice berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        return view('invoice-items.show', compact('invoice', 'invoiceItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        return view('invoice-items.edit', compact('invoice', 'invoiceItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice, InvoiceItem $invoiceItem)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ]);

        $invoiceItem->update($validated);

        return redirect()->route('invoices.invoice-items.index', $invoice)
            ->with('success', 'Item invoice berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();

        return redirect()->route('invoices.invoice-items.index', $invoice)
            ->with('success', 'Item invoice berhasil dihapus.');
    }
}
