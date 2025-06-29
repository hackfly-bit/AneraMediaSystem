@extends('layouts.app')

@section('title', 'Proyek')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Proyek</h1>
    <a href="{{ route('projects.create') }}" class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Tambah Proyek Baru
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Klien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Anggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Progres</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Tenggat Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($projects as $project)
                    <tr class="hover:bg-secondary-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">{{ $project->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900">{{ $project->name }}</div>
                            @if($project->description)
                                <div class="text-sm text-secondary-500">{{ \Illuminate\Support\Str::limit($project->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('clients.show', $project->client) }}" class="text-primary-600 hover:text-primary-800">
                                <div class="text-sm font-medium">{{ $project->client->name }}</div>
                            </a>
                            <div class="text-sm text-secondary-500">{{ $project->client->company }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">Rp. {{ number_format($project->budget, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $project->status == 'completed' ? 'bg-success-100 text-success-800' : ($project->status == 'in_progress' ? 'bg-primary-100 text-primary-800' : 'bg-secondary-100 text-secondary-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-secondary-200 rounded-full h-2.5">
                                <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                            <div class="text-xs text-secondary-500 mt-1">{{ $project->progress_percentage }}%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($project->deadline)
                                <span class="{{ $project->deadline < now() ? 'text-danger-600' : 'text-secondary-500' }}">
                                    {{ $project->deadline->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-secondary-400">Tidak ada tenggat waktu</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('projects.show', $project) }}" class="text-primary-600 hover:text-primary-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('projects.edit', $project) }}" class="text-warning-500 hover:text-warning-700" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger-600 hover:text-danger-900" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="text-secondary-500">
                                <i class="fas fa-folder-open text-4xl mb-4 text-secondary-400"></i>
                                <h3 class="text-lg font-medium text-secondary-900 mb-2">Tidak ada proyek yang ditemukan</h3>
                                <p class="text-secondary-500 mb-4">Mulailah dengan membuat proyek pertama Anda.</p>
                                <a href="{{ route('projects.create') }}" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Buat Proyek
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
    {{ $projects->links() }}
</div>
@endsection
