@extends('layouts.app')

@section('title', 'Buat Invoice Baru')

@section('content')
<div class="flex justify-between items-center mb-6 mt-4">
    <h1 class="text-2xl font-bold text-secondary-900">Buat Invoice Baru</h1>
    <a href="{{ route('invoices.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="flex justify-center">
    <div class="w-full max-w-4xl">
        <div class="card">
            <div class="p-8">
                <form action="{{ route('invoices.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="invoice_number" class="form-label">Nomor Invoice <span class="text-danger-500">*</span></label>
                            <input type="text" class="form-input"
                                   id="invoice_number" name="invoice_number" value="{{ old('invoice_number', 'INV-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}" required>
                            @error('invoice_number')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="client_id" class="form-label">Klien <span class="text-danger-500">*</span></label>
                            <select class="form-input" id="client_id" name="client_id" required>
                                <option value="">Pilih Klien</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }} - {{ $client->company }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="project_id" class="form-label">Proyek (Opsional)</label>
                            <select class="form-input" id="project_id" name="project_id">
                                <option value="">Pilih Proyek (Opsional)</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', request('project_id')) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }} ({{ $project->client->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label">Status <span class="text-danger-500">*</span></label>
                            <select class="form-input" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Tertunda</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                                <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                            @error('status')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="issue_date" class="form-label">Tanggal Diterbitkan <span class="text-danger-500">*</span></label>
                            <input type="date" class="form-input"
                                   id="issue_date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required>
                            @error('issue_date')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="due_date" class="form-label">Tanggal Jatuh Tempo <span class="text-danger-500">*</span></label>
                            <input type="date" class="text-input"
                                   id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                            @error('due_date')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="total_amount" class="form-label">Total Tagihan <span class="text-danger-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-secondary-500">Rp</span>
                                <input type="number" step="0.01" class="form-input pl-8"
                                       id="total_amount" name="total_amount" value="{{ old('total_amount') }}" required>
                            </div>
                            @error('total_amount')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tax_amount" class="form-label">Jumlah Pajak</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-secondary-500">Rp</span>
                                <input type="number" step="0.01" class="text-input pl-8"
                                       id="tax_amount" name="tax_amount" value="{{ old('tax_amount', 0) }}">
                            </div>
                            @error('tax_amount')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_amount" class="form-label">Jumlah Diskon</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-secondary-500">Rp</span>
                                <input type="number" step="0.01" class="text-input pl-8"
                                       id="discount_amount" name="discount_amount" value="{{ old('discount_amount', 0) }}">
                            </div>
                            @error('discount_amount')
                                <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-input"
                                  id="notes" name="notes" rows="4" placeholder="Catatan tambahan atau syarat pembayaran...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-danger-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-4 bg-primary-50 border-l-4 border-primary-500 text-primary-800 mb-6">
                        <div class="flex">
                            <div class="py-1"><i class="fas fa-info-circle mr-3"></i></div>
                            <div>
                                <p class="font-bold">Catatan:</p>
                                <p class="text-sm">Setelah membuat invoice, Anda dapat menambahkan rincian item untuk menentukan layanan atau produk yang disertakan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('invoices.index') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Buat Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-filter projects based on selected client
document.getElementById('client_id').addEventListener('change', function() {
    const clientId = this.value;
    const projectSelect = document.getElementById('project_id');
    const projects = @json($projects);

    // Clear current options except the first one
    projectSelect.innerHTML = '<option value="">Select Project (Optional)</option>';

    if (clientId) {
        // Filter projects by client
        const filteredProjects = projects.filter(project => project.client_id == clientId);

        filteredProjects.forEach(project => {
            const option = document.createElement('option');
            option.value = project.id;
            option.textContent = project.name;
            projectSelect.appendChild(option);
        });
    }
});

// Trigger the filter on page load if client is pre-selected
if (document.getElementById('client_id').value) {
    document.getElementById('client_id').dispatchEvent(new Event('change'));
}
</script>
@endsection
