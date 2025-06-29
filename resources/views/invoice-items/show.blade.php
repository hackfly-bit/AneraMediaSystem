@extends('layouts.app')

@section('title', 'Detail Item Invoice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-0">Detail Item Invoice</h1>
        <p class="text-muted mb-0">Invoice #{{ $invoice->invoice_number }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('invoices.invoice-items.edit', [$invoice, $invoiceItem]) }}" class="btn-warning">
            <i class="fas fa-edit me-1"></i>Edit Item
        </a>
        <a href="{{ route('invoices.invoice-items.index', $invoice) }}" class="btn-info">
            <i class="fas fa-list me-1"></i>Semua Item
        </a>
        <a href="{{ route('invoices.show', $invoice) }}" class="btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Invoice
        </a>
    </div>
</div>

<!-- Konteks Invoice -->
<div class="card shadow-sm mb-4">
    <div class="p-6">
        <div class="row">
            <div class="col-md-3">
                <h6 class="text-muted">Nomor Invoice</h6>
                <p class="mb-0">
                    <a href="{{ route('invoices.show', $invoice) }}" class="text-decoration-none">
                        <strong>#{{ $invoice->invoice_number }}</strong>
                    </a>
                </p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Klien</h6>
                <p class="mb-0">
                    <a href="{{ route('clients.show', $invoice->client) }}" class="text-decoration-none">
                        {{ $invoice->client->name }}
                    </a>
                    <br>
                    <small class="text-muted">{{ $invoice->client->company }}</small>
                </p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Proyek</h6>
                <p class="mb-0">
                    <a href="{{ route('projects.show', $invoice->project) }}" class="text-decoration-none">
                        {{ $invoice->project->name }}
                    </a>
                </p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Status Invoice</h6>
                <p class="mb-0">
                    @if($invoice->status === 'paid')
                        <span class="badge bg-success">{{ ucfirst($invoice->status) }}</span>
                    @elseif($invoice->status === 'pending')
                        <span class="badge bg-warning">{{ ucfirst($invoice->status) }}</span>
                    @elseif($invoice->status === 'overdue')
                        <span class="badge bg-danger">{{ ucfirst($invoice->status) }}</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($invoice->status) }}</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Detail Item -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Item</h5>
            </div>
            <div class="p-6">
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-muted">Deskripsi</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $invoiceItem->description }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <h6 class="text-muted">Kuantitas</h6>
                        <p class="mb-0">
                            <span class="fs-4 fw-bold text-primary">{{ number_format($invoiceItem->quantity, 2) }}</span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Harga Satuan</h6>
                        <p class="mb-0">
                            <span class="fs-4 fw-bold text-info">Rp. {{ number_format($invoiceItem->unit_price, 2) }}</span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Total Harga</h6>
                        <p class="mb-0">
                            <span class="fs-4 fw-bold text-success">Rp. {{ number_format($invoiceItem->total_price, 2) }}</span>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Dibuat</h6>
                        <p class="mb-0">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $invoiceItem->created_at->format('M d, Y') }}
                            <br>
                            <small class="text-muted">{{ $invoiceItem->created_at->format('h:i A') }}</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Terakhir Diperbarui</h6>
                        <p class="mb-0">
                            <i class="fas fa-clock me-1"></i>
                            {{ $invoiceItem->updated_at->format('M d, Y') }}
                            <br>
                            <small class="text-muted">{{ $invoiceItem->updated_at->format('h:i A') }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rincian Perhitungan -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Rincian Perhitungan</h5>
            </div>
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kuantitas:</td>
                                <td class="text-end">{{ number_format($invoiceItem->quantity, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Harga Satuan:</td>
                                <td class="text-end">Rp. {{ number_format($invoiceItem->unit_price, 2) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold fs-5">Total:</td>
                                <td class="text-end fs-5 fw-bold text-success">
                                    Rp. {{ number_format($invoiceItem->total_price, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-calculator me-2"></i>
                    <strong>Perhitungan:</strong> {{ number_format($invoiceItem->quantity, 2) }} × Rp. {{ number_format($invoiceItem->unit_price, 2) }} = Rp. {{ number_format($invoiceItem->total_price, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Tindakan Cepat -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Tindakan Cepat</h6>
            </div>
            <div class="p-6">
                <div class="d-grid gap-2">
                    <a href="{{ route('invoices.invoice-items.edit', [$invoice, $invoiceItem]) }}" class="btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Item Ini
                    </a>

                    <a href="{{ route('invoices.invoice-items.create', $invoice) }}" class="btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Item Baru
                    </a>

                    <hr>

                    <a href="{{ route('invoices.show', $invoice) }}" class="btn-primary">
                        <i class="fas fa-file-invoice me-2"></i>Lihat Invoice Lengkap
                    </a>

                    <a href="{{ route('clients.show', $invoice->client) }}" class="btn-info">
                        <i class="fas fa-user me-2"></i>Lihat Klien
                    </a>

                    <a href="{{ route('projects.show', $invoice->project) }}" class="btn-secondary">
                        <i class="fas fa-project-diagram me-2"></i>Lihat Proyek
                    </a>

                    <hr>

                    <form action="{{ route('invoices.invoice-items.destroy', [$invoice, $invoiceItem]) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Item
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Invoice Summary -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Invoice Summary</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">Total Items</h6>
                        <span class="fs-4 fw-bold text-primary">{{ $invoice->invoiceItems->count() }}</span>
                    </div>
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">Items Subtotal</h6>
                        <span class="fs-5 fw-bold text-success">Rp. {{ number_format($invoice->invoiceItems->sum('total_price'), 2) }}</span>
                    </div>
                    <div class="col-12">
                        <h6 class="text-muted">Invoice Total</h6>
                        <span class="fs-4 fw-bold text-success">Rp. {{ number_format($invoice->total_amount, 2) }}</span>
                    </div>
                </div>

                @if($invoice->tax_amount > 0 || $invoice->discount_amount > 0)
                <hr>
                <div class="small text-muted">
                    @if($invoice->discount_amount > 0)
                        <div class="d-flex justify-content-between">
                            <span>Discount:</span>
                            <span>-Rp. {{ number_format($invoice->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    @if($invoice->tax_amount > 0)
                        <div class="d-flex justify-content-between">
                            <span>Tax:</span>
                            <span>+Rp. {{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Other Items -->
        @if($invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->count() > 0)
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Other Items in Invoice</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->take(3) as $otherItem)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{  \Illuminate\Support\Str::limit($otherItem->description, 40) }}</h6>
                                <small class="text-muted">{{ $otherItem->quantity }} × Rp. {{ number_format($otherItem->unit_price, 2) }}</small>
                            </div>
                            <div class="text-end">
                                <strong class="text-success">Rp. {{ number_format($otherItem->total_price, 2) }}</strong>
                                <br>
                                <a href="{{ route('invoices.invoice-items.show', [$invoice, $otherItem]) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->count() > 3)
                    <div class="list-group-item px-0 text-center">
                        <small class="text-muted">... and {{ $invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->count() - 3 }} more items</small>
                    </div>
                    @endif
                </div>

                <div class="mt-3">
                    <a href="{{ route('invoices.invoice-items.index', $invoice) }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-list me-1"></i>View All Items
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
