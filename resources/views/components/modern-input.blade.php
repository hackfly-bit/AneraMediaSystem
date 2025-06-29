@props([
    'label' => null,
    'error' => null,
    'help' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'required' => false,
    'type' => 'text'
])

@php
$inputClasses = 'block w-full rounded-lg border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white shadow-sm transition-all duration-200 focus:border-primary-500 focus:ring-primary-500 sm:text-sm';

if ($error) {
    $inputClasses .= ' border-red-300 dark:border-red-600 focus:border-red-500 focus:ring-red-500';
}

if ($icon) {
    if ($iconPosition === 'left') {
        $inputClasses .= ' pl-10';
    } else {
        $inputClasses .= ' pr-10';
    }
}
@endphp

<div class="space-y-2">
    @if($label)
        <label {{ $attributes->only('id')->mapWithKeys(fn($value, $key) => ['for' => $value]) }} class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon && $iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400 dark:text-gray-500"></i>
            </div>
        @endif
        
        <input 
            type="{{ $type }}"
            {{ $attributes->except(['label', 'error', 'help', 'icon', 'iconPosition', 'required'])->merge([
                'class' => $inputClasses
            ]) }}
            @if($required) required @endif
        >
        
        @if($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400 dark:text-gray-500"></i>
            </div>
        @endif
    </div>
    
    @if($error)
        <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ $error }}
        </p>
    @endif
    
    @if($help && !$error)
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $help }}
        </p>
    @endif
</div>