@extends('layouts.app')

@section('title', 'Edit Klien')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-secondary-900">Edit Klien</h1>
    <div class="flex gap-2">
        <a href="{{ route('clients.show', $client) }}" class="btn-info">
            <i class="fas fa-eye mr-2"></i>Lihat
        </a>
        <a href="{{ route('clients.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Klien
        </a>
    </div>
</div>

<div class="flex justify-center">
    <div class="w-full md:w-8/12">
        <div class="card">
            <div class="p-6">
                <form action="{{ route('clients.update', $client) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="name" class="form-label">Nama <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input @error('name') border-red-500 @enderror" 
                                   id="name" name="name" value="{{ old('name', $client->name) }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="company" class="form-label">Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input @error('company') border-red-500 @enderror" 
                                   id="company" name="company" value="{{ old('company', $client->company) }}" required>
                            @error('company')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                            <input type="email" class="form-input @error('email') border-red-500 @enderror" 
                                   id="email" name="email" value="{{ old('email', $client->email) }}" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" class="form-input @error('phone') border-red-500 @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $client->phone) }}">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-input @error('address') border-red-500 @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $client->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                        <select class="form-select @error('status') border-red-500 @enderror" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="active" {{ old('status', $client->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $client->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('clients.show', $client) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Perbarui Klien
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection