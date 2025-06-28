@extends('layouts.app')

@section('title', 'Detail Klien')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Detail Klien</h1>
    <div class="flex space-x-2">
        <a href="{{ route('clients.edit', $client) }}" class="btn-warning">
            <i class="fas fa-edit mr-2"></i>Edit
        </a>
        <a href="{{ route('clients.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="card">
            <div class="p-6 bg-primary-500 text-white rounded-t-lg">
                <h5 class="text-lg font-bold"><i class="fas fa-user mr-2"></i>{{ $client->name }}</h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h6 class="text-sm font-bold text-secondary-500 mb-2">Perusahaan</h6>
                        <div class="form-input bg-secondary-50 border-0 mb-4">{{ $client->company }}</div>

                        <h6 class="text-sm font-bold text-secondary-500 mb-2">Email</h6>
                        <div class="form-input bg-secondary-50 border-0 mb-4">
                            <a href="mailto:{{ $client->email }}" class="text-primary-600 hover:underline">
                                <i class="fas fa-envelope mr-2"></i>{{ $client->email }}
                            </a>
                        </div>
                    </div>

                    <div>
                        <h6 class="text-sm font-bold text-secondary-500 mb-2">Telepon</h6>
                        <div class="form-input bg-secondary-50 border-0 mb-4">
                            @if($client->phone)
                                <a href="tel:{{ $client->phone }}" class="text-primary-600 hover:underline">
                                    <i class="fas fa-phone mr-2"></i>{{ $client->phone }}
                                </a>
                            @else
                                <span class="text-secondary-500">Tidak ada</span>
                            @endif
                        </div>

                        <h6 class="text-sm font-bold text-secondary-500 mb-2">Status</h6>
                        <div class="form-input bg-secondary-50 border-0 mb-4">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $client->status == 'active' ? 'bg-success-100 text-success-800' : 'bg-secondary-100 text-secondary-800' }}">
                                {{ ucfirst($client->status) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h6 class="text-sm font-bold text-secondary-500 mb-2">Alamat</h6>
                        <div class="form-input bg-secondary-50 border-0 mb-4 min-h-[80px]">
                            @if($client->address)
                                {{ $client->address }}
                            @else
                                <span class="text-secondary-500">Tidak ada</span>
                            @endif
                        </div>

                        <h6 class="text-sm font-bold text-secondary-500 mb-2">Tanggal Dibuat</h6>
                        <div class="form-input bg-secondary-50 border-0 mb-4">{{ $client->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="card mb-6">
            <div class="p-4 border-b border-secondary-200">
                <h6 class="font-bold text-secondary-800"><i class="fas fa-project-diagram mr-2"></i>Proyek</h6>
            </div>
            <div class="p-4">
                @if($client->projects->count() > 0)
                    <ul class="space-y-3">
                        @foreach($client->projects as $project)
                            <li>
                                <a href="{{ route('projects.show', $project) }}" class="text-primary-600 hover:underline font-semibold">
                                    {{ $project->name }}
                                </a>
                                <p class="text-sm text-secondary-500">{{ $project->status }}</p>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('projects.index') }}?client={{ $client->id }}" class="btn-secondary btn-sm">
                            Lihat Semua Proyek
                        </a>
                    </div>
                @else
                    <p class="text-secondary-500 mb-0">Belum ada proyek.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="p-4 border-b border-secondary-200">
                <h6 class="font-bold text-secondary-800"><i class="fas fa-file-invoice mr-2"></i>Invoice Terbaru</h6>
            </div>
            <div class="p-4">
                @if($client->invoices->count() > 0)
                    <ul class="space-y-4">
                        @foreach($client->invoices->take(5) as $invoice)
                            <li class="flex justify-between items-center">
                                <div>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-primary-600 hover:underline font-semibold">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                    <p class="text-sm text-secondary-500">Rp. {{ number_format($invoice->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($invoice->status == 'paid') bg-success-100 text-success-800
                                    @elseif($invoice->status == 'overdue') bg-danger-100 text-danger-800
                                    @else bg-warning-100 text-warning-800 @endif">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('invoices.index') }}?client={{ $client->id }}" class="btn-secondary btn-sm">
                            Lihat Semua Invoice
                        </a>
                    </div>
                @else
                    <p class="text-secondary-500 mb-0">Belum ada invoice.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
