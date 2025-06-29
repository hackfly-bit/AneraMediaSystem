@extends('layouts.app')

@section('title', 'Klien')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Klien</h1>
    <a href="{{ route('clients.create') }}" class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Tambah Klien Baru
    </a>
</div>

<div class="card p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-secondary-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Perusahaan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-secondary-200">
                @forelse($clients as $client)
                    <tr class="hover:bg-secondary-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-900">{{ $client->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->company }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $client->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('clients.edit', $client) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus klien ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-secondary-500">
                            <i class="fas fa-users text-4xl mb-4 opacity-50"></i>
                            <p>Belum ada klien yang terdaftar</p>
                            <a href="{{ route('clients.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Tambah klien pertama Anda
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($clients->hasPages())
<div class="mt-6">
    {{ $clients->links() }}
</div>
@endif
@endsection
