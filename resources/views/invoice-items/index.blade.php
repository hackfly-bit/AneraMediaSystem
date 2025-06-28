@extends('layouts.app')

@section('title', 'Rincian Invoice')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <div>
        <h1 class="text-2xl font-bold text-secondary-900">Rincian Invoice</h1>
        <p class="text-secondary-500">Invoice #{{ $invoice->invoice_number }}</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('invoices.invoice-items.create', $invoice) }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Tambah Item Baru
        </a>
        <a href="{{ route('invoices.show', $invoice) }}" class="btn-info">
            <i class="fas fa-eye mr-2"></i>Lihat Invoice
        </a>
        <a href="{{ route('invoices.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Invoice
        </a>
    </div>
</div>

<!-- Invoice Summary -->
<div class="card mb-6">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <h6 class="text-sm font-semibold text-secondary-500">Nomor Invoice</h6>
                <p class="font-bold text-secondary-800">#{{ $invoice->invoice_number }}</p>
            </div>
            <div>
                <h6 class="text-sm font-semibold text-secondary-500">Klien</h6>
                <p>
                    <a href="{{ route('clients.show', $invoice->client) }}" class="text-primary-600 hover:underline">
                        {{ $invoice->client->name }}
                    </a>
                </p>
            </div>
            <div>
                <h6 class="text-sm font-semibold text-secondary-500">Status</h6>
                <p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $invoice->status == 'paid' ? 'bg-success-100 text-success-800' : ($invoice->status == 'overdue' ? 'bg-danger-100 text-danger-800' : 'bg-warning-100 text-warning-800') }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </p>
            </div>
            <div>
                <h6 class="text-sm font-semibold text-secondary-500">Total Tagihan</h6>
                <p class="font-bold text-success-600">Rp. {{ number_format($invoice->total_amount, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th class="table-header">ID</th>
                        <th class="table-header">Deskripsi</th>
                        <th class="table-header text-center">Jumlah</th>
                        <th class="table-header text-right">Harga Satuan</th>
                        <th class="table-header text-right">Total Harga</th>
                        <th class="table-header text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($invoiceItems as $item)
                    <tr class="hover:bg-secondary-50">
                        <td class="table-data">{{ $item->id }}</td>
                        <td class="table-data font-medium text-secondary-900">{{ $item->description }}</td>
                        <td class="table-data text-center">{{ $item->quantity }}</td>
                        <td class="table-data text-right">Rp. {{ number_format($item->unit_price, 2) }}</td>
                        <td class="table-data text-right font-semibold">Rp. {{ number_format($item->total_price, 2) }}</td>
                        <td class="table-data text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('invoices.invoice-items.show', [$invoice, $item]) }}" class="text-info-600 hover:text-info-900" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('invoices.invoice-items.edit', [$invoice, $item]) }}" class="text-warning-600 hover:text-warning-900" title="Ubah">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('invoices.invoice-items.destroy', [$invoice, $item]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger-600 hover:text-danger-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-list-alt text-5xl text-secondary-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-secondary-900 mb-2">Belum ada item untuk invoice ini</h3>
                                <a href="{{ route('invoices.invoice-items.create', $invoice) }}" class="btn-primary mt-2">
                                    <i class="fas fa-plus mr-2"></i>Tambah Item Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($invoiceItems->count() > 0)
                <tfoot class="bg-secondary-50">
                    <tr>
                        <th colspan="4" class="px-6 py-3 text-right font-medium text-secondary-600">Subtotal:</th>
                        <th class="px-6 py-3 text-right font-medium text-secondary-800">Rp. {{ number_format($invoiceItems->sum('total_price'), 2) }}</th>
                        <th></th>
                    </tr>
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <th colspan="4" class="px-6 py-3 text-right font-medium text-secondary-600">Diskon:</th>
                        <th class="px-6 py-3 text-right font-medium text-danger-600">-Rp. {{ number_format($invoice->discount_amount, 2) }}</th>
                        <th></th>
                    </tr>
                    @endif
                    @if($invoice->tax_amount > 0)
                    <tr>
                        <th colspan="4" class="px-6 py-3 text-right font-medium text-secondary-600">Pajak:</th>
                        <th class="px-6 py-3 text-right font-medium text-secondary-800">Rp. {{ number_format($invoice->tax_amount, 2) }}</th>
                        <th></th>
                    </tr>
                    @endif
                    <tr class="bg-secondary-200">
                        <th colspan="4" class="px-6 py-3 text-right font-bold text-secondary-900 uppercase">Total:</th>
                        <th class="px-6 py-3 text-right text-lg font-bold text-secondary-900">Rp. {{ number_format($invoice->total_amount, 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@if($invoiceItems->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="card">
        <div class="p-6">
            <h6 class="text-lg font-bold text-secondary-800 mb-4">Ringkasan Item</h6>
            <div class="flex justify-between mb-2">
                <span class="text-secondary-600">Total Item:</span>
                <strong class="text-secondary-800">{{ $invoiceItems->count() }}</strong>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-secondary-600">Total Kuantitas:</span>
                <strong class="text-secondary-800">{{ $invoiceItems->sum('quantity') }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-secondary-600">Harga Satuan Rata-rata:</span>
                <strong class="text-secondary-800">Rp. {{ number_format($invoiceItems->avg('unit_price'), 2) }}</strong>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="p-6">
            <h6 class="text-lg font-bold text-secondary-800 mb-4">Aksi Cepat</h6>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('invoices.invoice-items.create', $invoice) }}" class="btn-primary btn-sm">
                    <i class="fas fa-plus mr-2"></i>Tambah Item Baru
                </a>
                <a href="{{ route('invoices.show', $invoice) }}" class="btn-info btn-sm">
                    <i class="fas fa-eye mr-2"></i>Lihat Invoice Lengkap
                </a>
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn-warning btn-sm">
                    <i class="fas fa-edit mr-2"></i>Ubah Detail Invoice
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<div class="mt-6">
    {{ $invoiceItems->links() }}
</div>
@endsection
