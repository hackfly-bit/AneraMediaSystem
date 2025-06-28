@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-secondary-700 dark:text-neutral-300 transition-colors duration-200']) }}>
    {{ $value ?? $slot }}
</label>
