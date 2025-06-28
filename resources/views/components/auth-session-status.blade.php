@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-success-600 dark:text-success-400 transition-colors duration-200']) }}>
        {{ $status }}
    </div>
@endif
