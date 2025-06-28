@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Daftar Invoice</h1>
    <a href="{{ route('invoices.create') }}" class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Buat Invoice Baru
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="card bg-primary-500 text-white">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-primary-100 text-sm font-medium">Total Invoice</h6>
                    <h4 class="text-2xl font-bold">{{ $invoices->total() }}</h4>
                </div>
                <i class="fas fa-file-invoice text-4xl text-primary-200"></i>
            </div>
        </div>
    </div>
    <div class="card bg-success-500 text-white">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-success-100 text-sm font-medium">Lunas</h6>
                    <h4 class="text-2xl font-bold">Rp {{ number_format($invoices->where('status', 'paid')->sum('total_amount'), 0, ',', '.') }}</h4>
                </div>
                <i class="fas fa-check-circle text-4xl text-success-200"></i>
            </div>
        </div>
    </div>
    <div class="card bg-warning-500 text-white">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-warning-100 text-sm font-medium">Tertunda</h6>
                    <h4 class="text-2xl font-bold">Rp {{ number_format($invoices->where('status', 'pending')->sum('total_amount'), 0, ',', '.') }}</h4>
                </div>
                <i class="fas fa-clock text-4xl text-warning-200"></i>
            </div>
        </div>
    </div>
    <div class="card bg-danger-500 text-white">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-danger-100 text-sm font-medium">Terlambat</h6>
                    <h4 class="text-2xl font-bold">Rp {{ number_format($invoices->where('status', 'overdue')->sum('total_amount'), 0, ',', '.') }}</h4>
                </div>
                <i class="fas fa-exclamation-circle text-4xl text-danger-200"></i>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">No. Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Klien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Tgl Terbit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-secondary-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-900">
                            #{{ $invoice->invoice_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            <a href="{{ route('clients.show', $invoice->client) }}" class="text-primary-600 hover:text-primary-900">
                                {{ $invoice->client->name }}
                            </a>
                            @if($invoice->client->company)
                                <div class="text-xs text-secondary-500">{{ $invoice->client->company }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            @if($invoice->project)
                                <a href="{{ route('projects.show', $invoice->project) }}" class="text-primary-600 hover:text-primary-900">
                                    {{ $invoice->project->name }}
                                </a>
                            @else
                                <span class="text-secondary-500">Tanpa Proyek</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-900">
                            {{ $invoice->formatted_total }}
                            @if($invoice->payment_percentage < 100)
                                <div class="text-xs text-secondary-500">
                                    Pembayaran ke-{{ $invoice->payment_sequence }} ({{ $invoice->payment_percentage }}%)
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($invoice->status == 'paid') bg-success-100 text-success-800
                                @elseif($invoice->status == 'overdue') bg-danger-100 text-danger-800
                                @else bg-warning-100 text-warning-800 @endif">
                                {{ $invoice->status_indonesian }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            {{ $invoice->issue_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            {{ $invoice->due_date->format('M d, Y') }}
                            @if($invoice->status == 'pending' && $invoice->due_date->isPast())
                                <div class="text-xs text-danger-600 mt-1">
                                    <i class="fas fa-exclamation-triangle inline h-3 w-3 mr-1"></i>
                                    Terlambat
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Preview Button -->
                                <livewire:invoice-preview :invoice="$invoice" :key="'preview-'.$invoice->id" />

                                <!-- View Button -->
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-primary-600 hover:text-primary-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-warning-500 hover:text-warning-700" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Download PDF Button -->
                                <a href="{{ route('invoices.pdf', $invoice) }}" class="text-success-600 hover:text-success-900" title="Download PDF" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger-600 hover:text-danger-900" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-file-invoice text-5xl text-secondary-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-secondary-900 mb-2">Tidak ada invoice ditemukan</h3>
                                <p class="text-secondary-500 mb-4">Mulai dengan membuat invoice pertama Anda.</p>
                                <a href="{{ route('invoices.create') }}" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Buat Invoice Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $invoices->links() }}
</div>
@endsection

