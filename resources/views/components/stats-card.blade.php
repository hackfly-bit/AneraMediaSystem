@props([
    'title',
    'value',
    'icon' => null,
    'color' => 'primary',
    'trend' => null,
    'trendDirection' => 'up',
    'description' => null
])

@php
$colorClasses = [
    'primary' => 'from-primary-500 to-primary-600',
    'secondary' => 'from-secondary-500 to-secondary-600',
    'success' => 'from-green-500 to-green-600',
    'warning' => 'from-yellow-500 to-yellow-600',
    'danger' => 'from-red-500 to-red-600',
    'info' => 'from-blue-500 to-blue-600'
];

$iconBgClasses = [
    'primary' => 'bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-300',
    'secondary' => 'bg-secondary-100 text-secondary-600 dark:bg-secondary-900 dark:text-secondary-300',
    'success' => 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300',
    'warning' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300',
    'danger' => 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300',
    'info' => 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300'
];
@endphp

<div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-200 dark:border-neutral-700 overflow-hidden">
    <div class="bg-gradient-to-r {{ $colorClasses[$color] }} h-2"></div>
    
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">{{ $title }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $value }}</p>
                
                @if($description)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $description }}</p>
                @endif
                
                @if($trend)
                    <div class="flex items-center mt-2">
                        @if($trendDirection === 'up')
                            <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                            <span class="text-sm text-green-600 dark:text-green-400 font-medium">{{ $trend }}</span>
                        @elseif($trendDirection === 'down')
                            <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i>
                            <span class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $trend }}</span>
                        @else
                            <i class="fas fa-minus text-gray-500 text-xs mr-1"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $trend }}</span>
                        @endif
                    </div>
                @endif
            </div>
            
            @if($icon)
                <div class="ml-4">
                    <div class="w-12 h-12 rounded-lg {{ $iconBgClasses[$color] }} flex items-center justify-center">
                        <i class="{{ $icon }} text-xl"></i>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>