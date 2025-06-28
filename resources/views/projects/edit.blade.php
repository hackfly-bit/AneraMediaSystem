@extends('layouts.app')

@section('title', 'Ubah Proyek')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Ubah Proyek</h1>
    <div class="flex space-x-3">
        <a href="{{ route('projects.show', $project) }}" class="btn-primary">
            <i class="fas fa-eye mr-2"></i>Lihat
        </a>
        <a href="{{ route('projects.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Proyek
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ubah Informasi Proyek</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('projects.update', $project) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <label for="name" class="form-label">Nama Proyek <span class="text-danger-500">*</span></label>
                            <input type="text" class="form-input @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $project->name) }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="client_id" class="form-label">Klien <span class="text-danger-500">*</span></label>
                            <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                <option value="">Pilih Klien</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }} - {{ $client->company }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-input @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <label for="budget" class="form-label">Anggaran <span class="text-danger-500">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" class="form-input @error('budget') is-invalid @enderror"
                                       id="budget" name="budget" value="{{ old('budget', $project->budget) }}" required>
                            </div>
                            @error('budget')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="status" class="form-label">Status <span class="text-danger-500">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="draft" {{ old('status', $project->status) == 'draft' ? 'selected' : '' }}>Konsep</option>
                                <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>Sedang Berjalan</option>
                                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <label for="progress_percentage" class="form-label">Persentase Progres <span class="text-danger-500">*</span></label>
                            <div class="input-group">
                                <input type="number" min="0" max="100" class="form-input @error('progress_percentage') is-invalid @enderror"
                                       id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', $project->progress_percentage) }}" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('progress_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="deadline" class="form-label">Tenggat Waktu</label>
                            <input type="date" class="form-input @error('deadline') is-invalid @enderror"
                                   id="deadline" name="deadline" value="{{ old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '') }}">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-input @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="3">{{ old('notes', $project->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('projects.show', $project) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Perbarui Proyek
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Proyek</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-secondary-900">Dibuat</h4>
                        <p class="text-sm text-secondary-600">{{ $project->created_at->translatedFormat('d M Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-secondary-900">Terakhir Diperbarui</h4>
                        <p class="text-sm text-secondary-600">{{ $project->updated_at->translatedFormat('d M Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-secondary-900">Status Saat Ini</h4>
                        <span class="badge {{ $project->status == 'completed' ? 'badge-success' : ($project->status == 'in_progress' ? 'badge-primary' : 'badge-secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-secondary-900">Progres</h4>
                        <div class="progress mt-1">
                            <div class="progress-bar" role="progressbar" style="width: {{ $project->progress_percentage }}%" aria-valuenow="{{ $project->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="text-xs text-secondary-500 mt-1">{{ $project->progress_percentage }}% selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
