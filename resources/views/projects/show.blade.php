@extends('layouts.app')

@section('title', 'Detail Proyek')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-3xl font-bold text-secondary-900">Detail Proyek</h1>
    <div class="flex space-x-2">
        <a href="{{ route('projects.edit', $project) }}" class="btn-secondary bg-warning-500 hover:bg-warning-600 text-white">
            <i class="fas fa-edit mr-2"></i>Ubah
        </a>
        <a href="{{ route('projects.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Proyek
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card mb-6">
            <div class="px-6 py-4 border-b border-secondary-200">
                <h5 class="text-xl font-semibold text-secondary-900">{{ $project->name }}</h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Klien</h6>
                        <p class="mb-4">
                            <a href="{{ route('clients.show', $project->client) }}" class="text-primary-600 hover:text-primary-800 no-underline">
                                <strong class="text-secondary-900">{{ $project->client->name }}</strong>
                            </a>
                            <br>
                            <small class="text-secondary-500">{{ $project->client->company }}</small>
                        </p>

                        <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Anggaran</h6>
                        <p class="mb-4">
                            <span class="text-2xl font-bold text-success-600">Rp. {{ number_format($project->budget, 2) }}</span>
                        </p>

                        <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Status</h6>
                        <p class="mb-4">
                            <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $project->status == 'completed' ? 'bg-success-100 text-success-800' : ($project->status == 'in_progress' ? 'bg-primary-100 text-primary-800' : 'bg-secondary-100 text-secondary-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Progres</h6>
                        <div class="mb-4">
                            <div class="w-full bg-secondary-200 rounded-full h-6">
                                <div class="bg-primary-600 h-6 rounded-full flex items-center justify-center text-white text-sm font-medium" style="width: {{ $project->progress_percentage }}%">
                                    {{ $project->progress_percentage }}%
                                </div>
                            </div>
                        </div>

                        <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Tenggat Waktu</h6>
                        <p class="mb-4 text-secondary-900">{{ $project->deadline ? $project->deadline->format('F d, Y') : 'Tidak diatur' }}</p>

                        <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Dibuat</h6>
                        <p class="mb-4 text-secondary-900">{{ $project->created_at->format('F d, Y') }}</p>
                    </div>
                </div>

                @if($project->description)
                <div class="mt-6 pt-6 border-t border-secondary-200">
                    <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Deskripsi</h6>
                    <p class="text-secondary-900 mt-2">{{ $project->description }}</p>
                </div>
                @endif

                @if($project->notes)
                <div class="mt-6 pt-6 border-t border-secondary-200">
                    <h6 class="text-sm font-medium text-secondary-500 uppercase tracking-wide">Catatan</h6>
                    <p class="text-secondary-900 mt-2">{{ $project->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Project Invoices -->
        <div class="card">
            <div class="px-6 py-4 border-b border-secondary-200 flex justify-between items-center">
                <h5 class="text-xl font-semibold text-secondary-900">Faktur Proyek</h5>
                <a href="{{ route('invoices.create', ['project_id' => $project->id]) }}" class="btn-primary text-sm">
                    <i class="fas fa-plus mr-2"></i>Buat Faktur
                </a>
            </div>
            <div class="p-6">
                @if($project->invoices->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-secondary-200">
                            <thead class="bg-secondary-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Faktur #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Tanggal Terbit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Tanggal Jatuh Tempo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-secondary-200">
                                @foreach($project->invoices as $invoice)
                                <tr class="hover:bg-secondary-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="text-primary-600 hover:text-primary-800 no-underline font-medium">
                                            #{{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-secondary-900">Rp. {{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $invoice->status == 'paid' ? 'bg-success-100 text-success-800' : ($invoice->status == 'overdue' ? 'bg-danger-100 text-danger-800' : 'bg-warning-100 text-warning-800') }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-secondary-900">{{ $invoice->issue_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-secondary-900">{{ $invoice->due_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="text-primary-600 hover:text-primary-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-invoice text-4xl text-secondary-400 mb-4"></i>
                        <p class="text-secondary-500 mb-4">Belum ada faktur yang dibuat untuk proyek ini.</p>
                        <a href="{{ route('invoices.create', ['project_id' => $project->id]) }}" class="btn-primary">
                            <i class="fas fa-plus mr-2"></i>Buat Faktur Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <!-- Project Summary -->
        <div class="card mb-6">
            <div class="px-6 py-4 border-b border-secondary-200">
                <h6 class="text-lg font-semibold text-secondary-900">Ringkasan Proyek</h6>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-secondary-600">Total Faktur:</span>
                    <strong class="text-secondary-900">{{ $project->invoices->count() }}</strong>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-secondary-600">Total Ditagih:</span>
                    <strong class="text-secondary-900">Rp. {{ number_format($project->invoices->sum('total_amount'), 2) }}</strong>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-secondary-600">Jumlah Dibayar:</span>
                    <strong class="text-success-600">Rp. {{ number_format($project->invoices->where('status', 'paid')->sum('total_amount'), 2) }}</strong>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-secondary-600">Jumlah Tertunda:</span>
                    <strong class="text-warning-600">Rp. {{ number_format($project->invoices->where('status', 'pending')->sum('total_amount'), 2) }}</strong>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-secondary-600">Jumlah Terlambat:</span>
                    <strong class="text-danger-600">Rp. {{ number_format($project->invoices->where('status', 'overdue')->sum('total_amount'), 2) }}</strong>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="px-6 py-4 border-b border-secondary-200">
                <h6 class="text-lg font-semibold text-secondary-900">Aksi Cepat</h6>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('projects.edit', $project) }}" class="btn-secondary bg-warning-500 hover:bg-warning-600 text-white w-full">
                        <i class="fas fa-edit mr-2"></i>Ubah Proyek
                    </a>
                    <a href="{{ route('invoices.create', ['project_id' => $project->id]) }}" class="btn-primary w-full">
                        <i class="fas fa-file-invoice mr-2"></i>Buat Faktur
                    </a>
                    <a href="{{ route('clients.show', $project->client) }}" class="btn-secondary w-full">
                        <i class="fas fa-user mr-2"></i>Lihat Klien
                    </a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="mt-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger w-full">
                            <i class="fas fa-trash mr-2"></i>Hapus Proyek
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
