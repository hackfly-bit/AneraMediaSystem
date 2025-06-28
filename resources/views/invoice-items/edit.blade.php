@extends('layouts.app')

@section('title', 'Edit Item Invoice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-0">Edit Item Invoice</h1>
        <p class="text-muted mb-0">Invoice #{{ $invoice->invoice_number }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('invoices.invoice-items.show', [$invoice, $invoiceItem]) }}" class="btn-info">
            <i class="fas fa-eye me-1"></i>Lihat Item
        </a>
        <a href="{{ route('invoices.invoice-items.index', $invoice) }}" class="btn-secondary">
            <i class="fas fa-list me-1"></i>Semua Item
        </a>
        <a href="{{ route('invoices.show', $invoice) }}" class="btn-outline-secondary">
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
                <h5 class="card-title mb-0">Edit Detail Item</h5>
            </div>
            <div class="p-6">
                <form action="{{ route('invoices.invoice-items.update', [$invoice, $invoiceItem]) }}" method="POST" id="itemForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-input @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Jelaskan layanan atau produk..." required>{{ old('description', $invoiceItem->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Kuantitas <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.01"
                                   class="form-input @error('quantity') is-invalid @enderror"
                                   id="quantity" name="quantity"
                                   value="{{ old('quantity', $invoiceItem->quantity) }}"
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
                                       id="unit_price" name="unit_price"
                                       value="{{ old('unit_price', $invoiceItem->unit_price) }}"
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
                                       id="total_price" name="total_price"
                                       value="{{ old('total_price', $invoiceItem->total_price) }}"
                                       required readonly>
                            </div>
                            @error('total_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Dihitung otomatis</small>
                        </div>
                    </div>

                    <!-- Perbandingan Nilai Saat Ini vs Baru -->
                    <div class="alert alert-light border">
                        <h6 class="alert-heading">Nilai Saat Ini vs Baru</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Kuantitas Saat Ini:</small>
                                <div class="fw-bold">{{ number_format($invoiceItem->quantity, 2) }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Harga Satuan Saat Ini:</small>
                                <div class="fw-bold">Rp. {{ number_format($invoiceItem->unit_price, 2) }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Total Saat Ini:</small>
                                <div class="fw-bold text-success">Rp. {{ number_format($invoiceItem->total_price, 2) }}</div>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Kuantitas Baru:</small>
                                <div class="fw-bold" id="new_quantity">{{ number_format($invoiceItem->quantity, 2) }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Harga Satuan Baru:</small>
                                <div class="fw-bold" id="new_unit_price">Rp. {{ number_format($invoiceItem->unit_price, 2) }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Total Baru:</small>
                                <div class="fw-bold text-primary" id="new_total">Rp. {{ number_format($invoiceItem->total_price, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Total harga akan dihitung secara otomatis berdasarkan kuantitas dan harga satuan.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('invoices.invoice-items.show', [$invoice, $invoiceItem]) }}" class="btn-secondary">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save me-1"></i>Perbarui Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Riwayat Item -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Informasi Item</h6>
            </div>
            <div class="p-6">
                <div class="mb-3">
                    <h6 class="text-muted">Dibuat</h6>
                    <p class="mb-0">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $invoiceItem->created_at->format('M d, Y') }}
                        <br>
                        <small class="text-muted">{{ $invoiceItem->created_at->format('h:i A') }}</small>
                    </p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Terakhir Diperbarui</h6>
                    <p class="mb-0">
                        <i class="fas fa-clock me-1"></i>
                        {{ $invoiceItem->updated_at->format('M d, Y') }}
                        <br>
                        <small class="text-muted">{{ $invoiceItem->updated_at->format('h:i A') }}</small>
                    </p>
                </div>

                @if($invoiceItem->created_at->ne($invoiceItem->updated_at))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small>This item has been modified since creation.</small>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('invoices.invoice-items.show', [$invoice, $invoiceItem]) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>View Item Details
                    </a>

                    <a href="{{ route('invoices.invoice-items.create', $invoice) }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add New Item
                    </a>

                    <hr>

                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-primary">
                        <i class="fas fa-file-invoice me-2"></i>View Full Invoice
                    </a>

                    <a href="{{ route('clients.show', $invoice->client) }}" class="btn btn-outline-info">
                        <i class="fas fa-user me-2"></i>View Client
                    </a>

                    <a href="{{ route('projects.show', $invoice->project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-project-diagram me-2"></i>View Project
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

        <!-- Other Items Preview -->
        @if($invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->count() > 0)
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Other Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->take(3) as $item)
                            <tr>
                                <td>
                                    <small>{{ Str::limit($item->description, 25) }}</small>
                                    <br>
                                    <small class="text-muted">{{ $item->quantity }} × Rp. {{ number_format($item->unit_price, 2) }}</small>
                                </td>
                                <td class="text-end">
                                    <small><strong>Rp. {{ number_format($item->total_price, 2) }}</strong></small>
                                </td>
                            </tr>
                            @endforeach
                            @if($invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->count() > 3)
                            <tr>
                                <td colspan="2" class="text-center">
                                    <small class="text-muted">... and {{ $invoice->invoiceItems->where('id', '!=', $invoiceItem->id)->count() - 3 }} more</small>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
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

<script>
function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
    const total = quantity * unitPrice;

    document.getElementById('total_price').value = total.toFixed(2);

    // Update comparison display
    document.getElementById('new_quantity').textContent = quantity.toFixed(2);
    document.getElementById('new_unit_price').textContent = '$' + unitPrice.toFixed(2);
    document.getElementById('new_total').textContent = '$' + total.toFixed(2);
}

// Calculate total on page load and input changes
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();

    // Add event listeners for real-time updates
    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('unit_price').addEventListener('input', calculateTotal);
});
</script>
@endsection
