@extends('layouts.app')

@section('title', 'Klien')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Daftar Klien</h1>
    <a href="{{ route('clients.create') }}" class="btn-primary">
        <i class="fas fa-plus mr-2"></i> Tambah Klien Baru
    </a>
</div>

<div class="card">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Perusahaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($clients as $client)
                    <tr class="hover:bg-secondary-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-900">{{ $client->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->company }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $client->status == 'active' ? 'bg-success-100 text-success-800' : 'bg-secondary-100 text-secondary-800' }}">
                                {{ ucfirst($client->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('clients.show', $client) }}" class="text-primary-600 hover:text-primary-900" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('clients.edit', $client) }}" class="text-warning-600 hover:text-warning-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klien ini?')">
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
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-5xl text-secondary-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-secondary-900 mb-2">Belum ada klien</h3>
                                <p class="text-secondary-500 mb-4">Mulai dengan membuat klien pertama Anda.</p>
                                <a href="{{ route('clients.create') }}" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i> Tambah Klien Baru
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

@if($clients->hasPages())
<div class="mt-6">
    {{ $clients->links() }}
</div>
@endif
@endsection
