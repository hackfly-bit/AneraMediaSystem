@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Invoice #{{ $invoice->invoice_number }}</h1>
    <div class="flex space-x-2">
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn-warning">
            <i class="fas fa-edit mr-2"></i>Edit
        </a>
        <a href="{{ route('invoices.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <!-- Invoice Header -->
        <div class="card mb-6">
            <div class="p-6 flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold text-secondary-800">Invoice #{{ $invoice->invoice_number }}</h2>
                    <p class="text-sm text-secondary-500">Diterbitkan pada: {{ $invoice->issue_date->format('d M Y') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-semibold rounded-full
                    @if($invoice->status == 'paid') bg-success-100 text-success-800
                    @elseif($invoice->status == 'overdue') bg-danger-100 text-danger-800
                    @else bg-warning-100 text-warning-800 @endif">
                    {{ $invoice->status_indonesian }}
                </span>
            </div>
            <div class="p-6 border-t border-secondary-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h6 class="text-sm font-semibold text-secondary-600 mb-2">Ditagihkan Kepada:</h6>
                        <p class="text-secondary-800">
                            <strong class="font-bold">{{ $invoice->client->name }}</strong><br>
                            {{ $invoice->client->company }}<br>
                            {{ $invoice->client->email }}<br>
                            @if($invoice->client->phone)
                                {{ $invoice->client->phone }}<br>
                            @endif
                            @if($invoice->client->address)
                                {{ $invoice->client->address }}
                            @endif
                        </p>

                        @if($invoice->project)
                        <h6 class="text-sm font-semibold text-secondary-600 mt-4 mb-2">Proyek:</h6>
                        <p>
                            <a href="{{ route('projects.show', $invoice->project) }}" class="text-primary-600 hover:text-primary-800 font-semibold">
                                {{ $invoice->project->name }}
                            </a>
                            @if($invoice->project->description)
                                <br><small class="text-secondary-500">{{ Str::limit($invoice->project->description, 100) }}</small>
                            @endif
                        </p>
                        @endif
                    </div>

                    <div>
                        <h6 class="text-sm font-semibold text-secondary-600 mb-2">Detail Invoice:</h6>
                        <table class="min-w-full">
                            <tbody>
                                <tr class="border-b border-secondary-200">
                                    <td class="py-2 text-sm text-secondary-600">Jatuh Tempo:</td>
                                    <td class="py-2 text-sm text-secondary-800 text-right">
                                        {{ $invoice->due_date->format('d M Y') }}
                                        @if($invoice->status == 'pending' && $invoice->due_date->isPast())
                                            <br><small class="text-danger-600"><i class="fas fa-exclamation-triangle mr-1"></i> Terlambat</small>
                                        @endif
                                    </td>
                                </tr>
                                @if($invoice->tax_amount > 0)
                                <tr class="border-b border-secondary-200">
                                    <td class="py-2 text-sm text-secondary-600">Pajak:</td>
                                    <td class="py-2 text-sm text-secondary-800 text-right">{{ $invoice->formatted_tax }}</td>
                                </tr>
                                @endif
                                @if($invoice->discount_amount > 0)
                                <tr class="border-b border-secondary-200">
                                    <td class="py-2 text-sm text-secondary-600">Diskon:</td>
                                    <td class="py-2 text-sm text-secondary-800 text-right">-{{ $invoice->formatted_discount }}</td>
                                </tr>
                                @endif
                                <tr class="border-b border-secondary-200">
                                    <td class="py-2 text-sm font-bold text-secondary-700">Total Tagihan:</td>
                                    <td class="py-2 text-xl font-bold text-success-600 text-right">{{ $invoice->formatted_total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($invoice->notes)
                <div class="mt-6">
                    <h6 class="text-sm font-semibold text-secondary-600 mb-2">Catatan:</h6>
                    <p class="text-sm text-secondary-700 p-4 bg-secondary-50 rounded-md">{{ $invoice->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="card">
            <div class="p-6 flex justify-between items-center">
                <h5 class="text-lg font-bold text-secondary-800">Rincian Tagihan</h5>
                <a href="{{ route('invoice-items.create', $invoice) }}" class="btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>Tambah Item
                </a>
            </div>
            <div class="p-6 border-t border-secondary-200">
                @if($invoice->invoiceItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-secondary-200">
                            <thead class="bg-secondary-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">Harga Satuan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-secondary-200">
                                @foreach($invoice->invoiceItems as $item)
                                <tr class="hover:bg-secondary-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-800">{{ $item->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-800 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-800 text-right">{{ $item->formatted_unit_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-secondary-900 text-right">{{ $item->formatted_total_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('invoices.invoice-items.show', [$invoice, $item]) }}" class="text-primary-600 hover:text-primary-900" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('invoices.invoice-items.edit', [$invoice, $item]) }}" class="text-warning-500 hover:text-warning-700" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('invoices.invoice-items.destroy', [$invoice, $item]) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger-600 hover:text-danger-900" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-secondary-50">
                                <tr>
                                    <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-secondary-600">Subtotal:</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium text-secondary-800">{{ $invoice->formatted_subtotal }}</th>
                                    <th></th>
                                </tr>
                                @if($invoice->discount_amount > 0)
                                <tr>
                                    <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-secondary-600">Diskon:</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium text-danger-600">-{{ $invoice->formatted_discount }}</th>
                                    <th></th>
                                </tr>
                                @endif
                                @if($invoice->tax_amount > 0)
                                <tr>
                                    <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-secondary-600">Pajak:</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium text-secondary-800">{{ $invoice->formatted_tax }}</th>
                                    <th></th>
                                </tr>
                                @endif
                                <tr class="bg-secondary-200">
                                    <th colspan="3" class="px-6 py-3 text-right text-sm font-bold text-secondary-900 uppercase">Total:</th>
                                    <th class="px-6 py-3 text-right text-lg font-bold text-secondary-900">{{ $invoice->formatted_total }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="fas fa-list-alt fa-3x text-secondary-300 mb-4"></i>
                        <p class="text-secondary-500 mb-4">Belum ada item yang ditambahkan ke invoice ini.</p>
                        <a href="{{ route('invoice-items.create', $invoice) }}" class="btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>Tambah Item Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <!-- Invoice Summary -->
        <div class="card mb-6">
            <div class="p-6">
                <h6 class="text-lg font-bold text-secondary-800 mb-4">Ringkasan Invoice</h6>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-secondary-600">Jumlah Item:</span>
                    <strong class="text-sm font-semibold text-secondary-800">{{ $invoice->invoiceItems->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong>Rp. {{ number_format($invoice->invoiceItems->sum('total_price'), 2) }}</strong>
                </div>
                @if($invoice->discount_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span>Discount:</span>
                    <strong class="text-danger">-Rp. {{ number_format($invoice->discount_amount, 2) }}</strong>
                </div>
                @endif
                @if($invoice->tax_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax:</span>
                    <strong>Rp. {{ number_format($invoice->tax_amount, 2) }}</strong>
                </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between">
                    <span><strong>Total Amount:</strong></span>
                    <strong class="text-success h5">Rp. {{ number_format($invoice->total_amount, 2) }}</strong>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit Invoice
                    </a>
                    <a href="{{ route('invoice-items.create', $invoice) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Add Item
                    </a>
                    <a href="{{ route('clients.show', $invoice->client) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-user me-1"></i>View Client
                    </a>
                    @if($invoice->project)
                    <a href="{{ route('projects.show', $invoice->project) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-project-diagram me-1"></i>View Project
                    </a>
                    @endif
                    <hr>
                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash me-1"></i>Delete Invoice
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
