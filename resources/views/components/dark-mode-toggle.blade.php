<div x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggle() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        this.updateTheme();
    },
    updateTheme() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" 
x-init="updateTheme()" 
class="relative">
    <button 
        @click="toggle()" 
        class="flex items-center justify-center w-10 h-10 rounded-lg bg-secondary-100 hover:bg-secondary-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
        :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
    >
        <!-- Sun Icon (Light Mode) -->
        <svg 
            x-show="!darkMode" 
            class="w-5 h-5 text-secondary-600 dark:text-neutral-400" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
            ></path>
        </svg>
        
        <!-- Moon Icon (Dark Mode) -->
        <svg 
            x-show="darkMode" 
            class="w-5 h-5 text-secondary-600 dark:text-neutral-400" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
            ></path>
        </svg>
    </button>
</div>