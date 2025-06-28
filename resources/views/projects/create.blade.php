@extends('layouts.app')

@section('title', 'Buat Proyek')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Buat Proyek Baru</h1>
    <a href="{{ route('projects.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Proyek
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Proyek</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <label for="name" class="form-label">Nama Proyek <span class="text-danger-500">*</span></label>
                            <input type="text" class="form-input @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="client_id" class="form-label">Klien <span class="text-danger-500">*</span></label>
                            <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                <option value="">Pilih Klien</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
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
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
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
                                       id="budget" name="budget" value="{{ old('budget') }}" required>
                            </div>
                            @error('budget')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="status" class="form-label">Status <span class="text-danger-500">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Konsep</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Sedang Berjalan</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
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
                                       id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', 0) }}" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('progress_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="deadline" class="form-label">Tenggat Waktu</label>
                            <input type="date" class="form-input @error('deadline') is-invalid @enderror"
                                   id="deadline" name="deadline" value="{{ old('deadline') }}">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-input @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('projects.index') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan Proyek
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
                 <h3 class="card-title">Tips Cepat</h3>
             </div>
             <div class="card-body">
                 <div class="space-y-4">
                     <div class="flex items-start space-x-3">
                         <div class="flex-shrink-0">
                             <i class="fas fa-lightbulb text-yellow-500"></i>
                         </div>
                         <div>
                             <h4 class="text-sm font-medium text-secondary-900">Nama Proyek</h4>
                             <p class="text-sm text-secondary-600">Pilih nama yang jelas dan deskriptif yang mencerminkan tujuan proyek.</p>
                         </div>
                     </div>

                     <div class="flex items-start space-x-3">
                         <div class="flex-shrink-0">
                             <i class="fas fa-dollar-sign text-green-500"></i>
                         </div>
                         <div>
                             <h4 class="text-sm font-medium text-secondary-900">Perencanaan Anggaran</h4>
                             <p class="text-sm text-secondary-600">Tetapkan anggaran realistis yang mencakup semua persyaratan proyek dan kemungkinan tak terduga.</p>
                         </div>
                     </div>

                     <div class="flex items-start space-x-3">
                         <div class="flex-shrink-0">
                             <i class="fas fa-calendar text-blue-500"></i>
                         </div>
                         <div>
                             <h4 class="text-sm font-medium text-secondary-900">Pengaturan Tenggat Waktu</h4>
                             <p class="text-sm text-secondary-600">Pertimbangkan kompleksitas proyek dan ketersediaan tim saat menetapkan tenggat waktu.</p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
</div>
@endsection
