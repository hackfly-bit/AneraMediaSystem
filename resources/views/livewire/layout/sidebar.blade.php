<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-neutral-900 dark:bg-neutral-950 text-white min-h-screen flex flex-col expanded custom-scrollbar overflow-y-auto transition-colors duration-200">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 border-b border-neutral-700 dark:border-neutral-800">
        <div class="flex items-center space-x-3">
            <x-application-logo class="h-8 w-8 text-white" />
            <span class="sidebar-text text-xl font-semibold">{{ config('app.name', 'Invoice') }}</span>
        </div>
        <button id="sidebar-toggle" class="hidden md:block p-1 rounded-md hover:bg-neutral-700 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <div class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors duration-200">
            <a href="{{ route('dashboard') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </div>

        <!-- Clients -->
        <div class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors duration-200">
            <a href="{{ route('clients.index') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="sidebar-text">Clients</span>
            </a>
        </div>

        <!-- Projects -->
        <div class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors duration-200">
            <a href="{{ route('projects.index') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span class="sidebar-text">Projects</span>
            </a>
        </div>

        <!-- Invoices -->
        <div class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors duration-200">
            <a href="{{ route('invoices.index') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="sidebar-text">Invoices</span>
            </a>
        </div>

        <!-- Divider -->
        <div class="border-t border-neutral-700 dark:border-neutral-800 my-4"></div>

        <!-- Reports -->
        <div class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors duration-200">
            <a href="#" class="flex items-center w-full">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="sidebar-text">Reports</span>
            </a>
        </div>

        <!-- Settings -->
        <div class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-neutral-700 dark:hover:bg-neutral-600 transition-colors duration-200">
            <a href="{{ route('profile.edit') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="sidebar-text">Settings</span>
            </a>
        </div>
    </nav>

    <!-- User Profile Section -->
    <div class="border-t border-neutral-700 dark:border-neutral-800 p-4">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                </div>
            </div>
            <div class="sidebar-text flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-neutral-400 truncate">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>
        
        <!-- Logout Button -->
        <div class="mt-3">
            <button wire:click="logout" class="sidebar-item w-full flex items-center px-3 py-2 rounded-md text-sm font-medium text-danger-400 hover:bg-danger-900 dark:hover:bg-danger-800 hover:text-danger-300 transition-colors duration-200">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="sidebar-text">Logout</span>
            </button>
        </div>
    </div>
</aside>
</div>