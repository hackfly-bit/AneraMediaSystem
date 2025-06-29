<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased transition-colors duration-200">
        <div class="h-screen bg-secondary-100 dark:bg-neutral-900 flex transition-colors duration-200">
            <!-- Sidebar -->
            <livewire:layout.sidebar />

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white dark:bg-neutral-800 shadow-sm border-b border-secondary-200 dark:border-neutral-700">
                    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <div class="flex items-center">
                                <h1 class="text-xl font-semibold text-secondary-900 dark:text-white">Invoice Management</h1>
                            </div>
                            <div class="flex items-center space-x-4">
                                <!-- Dark Mode Toggle -->
                                @include('components.dark-mode-toggle')

                                @auth
                                    <span class="text-sm text-secondary-600 dark:text-neutral-300">{{ auth()->user()->name }}</span>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-ghost text-sm">
                                            <i class="fas fa-sign-out-alt mr-1"></i>
                                            Logout
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-neutral-800 shadow-sm border-b border-secondary-200 dark:border-neutral-700">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <div class="text-secondary-900 dark:text-white">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-2 bg-secondary-50 dark:bg-neutral-900 transition-colors duration-200 overflow-auto">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </main>
            </div>
        </div>
    </body>
</html>
