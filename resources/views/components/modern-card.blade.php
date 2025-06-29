@props([
    'title' => null,
    'subtitle' => null,
    'padding' => 'p-6',
    'shadow' => 'shadow-lg',
    'hover' => true,
    'border' => true
])

<div {{ $attributes->merge([
    'class' => 'bg-white dark:bg-neutral-800 rounded-xl ' . $shadow . ' transition-all duration-300 ' . 
               ($hover ? 'hover:shadow-xl hover:-translate-y-1' : '') . ' ' . 
               ($border ? 'border border-gray-200 dark:border-neutral-700' : '')
]) }}>
    @if($title || $subtitle)
        <div class="{{ $padding }} border-b border-gray-200 dark:border-neutral-700">
            @if($title)
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>