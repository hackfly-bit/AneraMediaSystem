@extends('layouts.app')

@section('title', 'Tambah Item Invoice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-0">Tambah Item Invoice</h1>
        <p class="text-muted mb-0">Invoice #{{ $invoice->invoice_number }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('invoices.invoice-items.index', $invoice) }}" class="btn-info">
            <i class="fas fa-list me-1"></i>Lihat Item
        </a>
        <a href="{{ route('invoices.show', $invoice) }}" class="btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Invoice
        </a>
    </div>
</div>

<!-- Ringkasan Invoice -->
<div class="card shadow-sm mb-4">
    <div class="p-6">
        <div class="row">
            <div class="col-md-3">
                <h6 class="text-muted">Nomor Invoice</h6>
                <p class="mb-0"><strong>#{{ $invoice->invoice_number }}</strong></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Klien</h6>
                <p class="mb-0">
                    <a href="{{ route('clients.show', $invoice->client) }}" class="text-decoration-none">
                        {{ $invoice->client->name }}
                    </a>
                </p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Item Saat Ini</h6>
                <p class="mb-0"><strong>{{ $invoice->invoiceItems->count() }}</strong></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Total Saat Ini</h6>
                <p class="mb-0"><strong class="text-success">Rp. {{ number_format($invoice->total_amount, 2) }}</strong></p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Item Baru</h5>
            </div>
            <div class="p-6">
                <form action="{{ route('invoices.invoice-items.store', $invoice) }}" method="POST" id="itemForm">
                    @csrf

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-input @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Jelaskan layanan atau produk..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Kuantitas <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.01"
                                   class="form-input @error('quantity') is-invalid @enderror"
                                   id="quantity" name="quantity" value="{{ old('quantity', 1) }}"
                                   required onchange="calculateTotal()">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="unit_price" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" min="0"
                                       class="form-input @error('unit_price') is-invalid @enderror"
                                       id="unit_price" name="unit_price" value="{{ old('unit_price') }}"
                                       required onchange="calculateTotal()">
                            </div>
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total_price" class="form-label">Total Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" min="0"
                                       class="form-input @error('total_price') is-invalid @enderror"
                                       id="total_price" name="total_price" value="{{ old('total_price') }}"
                                       required readonly>
                            </div>
                            @error('total_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Dihitung otomatis</small>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Total harga akan dihitung secara otomatis berdasarkan kuantitas dan harga satuan.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn-secondary">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save me-1"></i>Tambah Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Pratinjau Item yang Ada -->
        @if($invoice->invoiceItems->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Item yang Ada</h6>
            </div>
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->invoiceItems->take(5) as $item)
                            <tr>
                                <td>
                                    <small>{{ Str::limit($item->description, 30) }}</small>
                                    <br>
                                    <small class="text-muted">{{ $item->quantity }} × Rp. {{ number_format($item->unit_price, 2) }}</small>
                                </td>
                                <td class="text-end">
                                    <small><strong>Rp. {{ number_format($item->total_price, 2) }}</strong></small>
                                </td>
                            </tr>
                            @endforeach
                            @if($invoice->invoiceItems->count() > 5)
                            <tr>
                                <td colspan="2" class="text-center">
                                    <small class="text-muted">... dan {{ $invoice->invoiceItems->count() - 5 }} item lainnya</small>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>Subtotal:</th>
                                <th class="text-end">Rp. {{ number_format($invoice->invoiceItems->sum('total_price'), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('invoices.invoice-items.index', $invoice) }}" class="btn-outline-primary btn-sm w-100">
                        <i class="fas fa-list me-1"></i>Lihat Semua Item
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="card shadow-sm">
            <div class="p-6 text-center">
                <i class="fas fa-list fa-2x text-muted mb-3"></i>
                <h6 class="text-muted">Belum Ada Item</h6>
                <p class="text-muted mb-0">Ini akan menjadi item pertama untuk invoice ini.</p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
    const total = quantity * unitPrice;

    document.getElementById('total_price').value = total.toFixed(2);
}

// Calculate total on page load if values exist
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endsection
