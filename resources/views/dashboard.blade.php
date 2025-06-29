<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-semibold text-xl text-secondary-800 dark:text-white leading-tight transition-colors duration-200">
            {{ __('Dasbor') }}
        </h2>
    </x-slot>

    <!-- Statistics Cards -->
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Clients -->
            <x-stats-card title="Total Klien" :value="\App\Models\Client::count()" icon="fas fa-users" color="primary"
                description="Klien terdaftar" />

            <!-- Total Projects -->
            <x-stats-card title="Total Proyek" :value="\App\Models\Project::count()" icon="fas fa-project-diagram" color="secondary"
                description="Proyek aktif" />

            <!-- Total Invoices -->
            <x-stats-card title="Total Invoice" :value="\App\Models\Invoice::count()" icon="fas fa-file-invoice" color="info"
                description="Invoice dibuat" />

            <!-- Total Revenue -->
            <x-stats-card title="Total Pendapatan"
                value="Rp {{ number_format(\App\Models\Invoice::sum('total'), 0, ',', '.') }}" icon="fas fa-dollar-sign"
                color="success" description="Pendapatan kotor" />
        </div>

        <!-- Invoice Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <x-stats-card title="Total Invoice" :value="\App\Models\Invoice::count()" icon="fas fa-file-invoice" color="primary"
                description="Semua invoice" />

            <x-stats-card title="Lunas"
                value="Rp {{ number_format(\App\Models\Invoice::where('status', 'paid')->sum('total_amount'), 0, ',', '.') }}"
                icon="fas fa-check-circle" color="success" description="Invoice terbayar" />

            <x-stats-card title="Tertunda"
                value="Rp {{ number_format(\App\Models\Invoice::where('status', 'pending')->sum('total_amount'), 0, ',', '.') }}"
                icon="fas fa-clock" color="warning" description="Menunggu pembayaran" />

            <x-stats-card title="Terlambat"
                value="Rp {{ number_format(\App\Models\Invoice::where('status', 'overdue')->sum('total_amount'), 0, ',', '.') }}"
                icon="fas fa-exclamation-circle" color="danger" description="Melewati jatuh tempo" />
        </div>

        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <x-modern-card title="Selamat Datang!" subtitle="Anda berhasil masuk ke sistem">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">Dashboard Invoice Management
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">Kelola klien, proyek, dan invoice Anda dengan
                                mudah</p>
                        </div>
                    </div>
                </x-modern-card>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-medium text-secondary-900 dark:text-white transition-colors duration-200 mb-4">
                    Tindakan Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Klien Baru
                    </a>
                    <a href="{{ route('projects.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Proyek Baru
                    </a>
                    <a href="{{ route('invoices.create') }}" class="btn btn-warning">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Faktur Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>




</x-app-layout>
