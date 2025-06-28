@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-secondary-300 dark:border-neutral-700 rounded-lg bg-white dark:bg-neutral-800 text-secondary-900 dark:text-white placeholder-secondary-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
