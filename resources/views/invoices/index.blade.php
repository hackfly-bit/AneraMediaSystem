@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Invoice</h1>
    <a href="{{ route('invoices.create') }}" class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Buat Invoice Baru
    </a>
</div>

<div class="card p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full">
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
                            <a href="{{ route('clients.show', $invoice->client) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $invoice->client->name }}
                            </a>
                            @if($invoice->client->company)
                                <div class="text-xs text-secondary-500">{{ $invoice->client->company }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            @if($invoice->project)
                                <a href="{{ route('projects.show', $invoice->project) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $invoice->project->name }}
                                </a>
                            @else
                                <span class="text-secondary-500">Tanpa Proyek</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            {{ $invoice->formatted_total }}
                            @if($invoice->payment_percentage < 100)
                                <div class="text-xs text-secondary-500">
                                    Pembayaran ke-{{ $invoice->payment_sequence }} ({{ $invoice->payment_percentage }}%)
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($invoice->status == 'paid') bg-green-100 text-green-800
                                @elseif($invoice->status == 'overdue') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $invoice->status_indonesian }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $invoice->issue_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                            {{ $invoice->due_date->format('M d, Y') }}
                            @if($invoice->status == 'pending' && $invoice->due_date->isPast())
                                <div class="text-xs text-red-600 mt-1">
                                    <i class="fas fa-exclamation-triangle inline h-3 w-3 mr-1"></i>
                                    Terlambat
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">

                                 <!-- Preview Button -->
                                <livewire:invoice-preview :invoice="$invoice" :key="'preview-'.$invoice->id" />

                                <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('invoices.pdf', $invoice) }}" class="text-green-600 hover:text-green-900" title="Download PDF" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus invoice ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-secondary-500">
                            <i class="fas fa-file-invoice text-4xl mb-4 opacity-50"></i>
                            <p>Tidak ada invoice ditemukan</p>
                            <a href="{{ route('invoices.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Buat invoice pertama Anda
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $invoices->links() }}
</div>
@endsection

