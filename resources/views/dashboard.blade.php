<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-800 dark:text-white leading-tight transition-colors duration-200">
            {{ __('Dasbor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 transition-colors duration-200">
                <div class="p-6 text-secondary-900 dark:text-white">
                    <h3 class="text-lg font-medium mb-2 transition-colors duration-200">Selamat datang kembali, {{ auth()->user()->name }}!</h3>
                    <p class="text-secondary-600 dark:text-neutral-400 transition-colors duration-200">Berikut adalah ikhtisar sistem manajemen faktur Anda.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Clients -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users fa-2x text-primary-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-500 dark:text-neutral-400 transition-colors duration-200">Total Klien</p>
                                <p class="text-2xl font-semibold text-secondary-900 dark:text-white transition-colors duration-200">{{ \App\Models\Client::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('clients.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 text-sm font-medium transition-colors duration-200">Lihat semua klien →</a>
                        </div>
                    </div>
                </div>

                <!-- Total Projects -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-briefcase fa-2x text-success-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-500 dark:text-neutral-400 transition-colors duration-200">Total Proyek</p>
                                <p class="text-2xl font-semibold text-secondary-900 dark:text-white transition-colors duration-200">{{ \App\Models\Project::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('projects.index') }}" class="text-success-600 dark:text-success-400 hover:text-success-800 dark:hover:text-success-300 text-sm font-medium transition-colors duration-200">Lihat semua proyek →</a>
                        </div>
                    </div>
                </div>

                <!-- Total Invoices -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-invoice-dollar fa-2x text-accent-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-500 dark:text-neutral-400 transition-colors duration-200">Total Faktur</p>
                                <p class="text-2xl font-semibold text-secondary-900 dark:text-white transition-colors duration-200">{{ \App\Models\Invoice::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('invoices.index') }}" class="text-accent-600 dark:text-accent-400 hover:text-accent-800 dark:hover:text-accent-300 text-sm font-medium transition-colors duration-200">Lihat semua faktur →</a>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-dollar-sign fa-2x text-warning-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-500 dark:text-neutral-400 transition-colors duration-200">Total Pendapatan</p>
                                <p class="text-2xl font-semibold text-secondary-900 dark:text-white transition-colors duration-200">Rp. {{ number_format(\App\Models\Invoice::sum('total'), 2) }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-warning-600 dark:text-warning-400 text-sm font-medium transition-colors duration-200">Pendapatan sepanjang waktu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-medium text-secondary-900 dark:text-white transition-colors duration-200 mb-4">Tindakan Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Klien Baru
                        </a>
                        <a href="{{ route('projects.create') }}" class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Proyek Baru
                        </a>
                        <a href="{{ route('invoices.create') }}" class="btn btn-accent">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Faktur Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
