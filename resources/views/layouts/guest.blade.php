<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-secondary-900 dark:text-white antialiased transition-colors duration-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-secondary-100 dark:bg-neutral-900 transition-colors duration-200">
            <div class="flex items-center gap-4">
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-secondary-500 dark:text-white" />
                </a>
                @include('components.dark-mode-toggle')
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-neutral-800 shadow-md overflow-hidden sm:rounded-lg border border-secondary-200 dark:border-neutral-700 transition-colors duration-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
