@extends('layouts.app')

@section('title', 'Style Guide')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gradient mb-2">Style Guide</h1>
        <p class="text-lg text-secondary-600 dark:text-neutral-300">Panduan komponen dan styling untuk aplikasi Invoice</p>
        
        <!-- Dark Mode Toggle Demo -->
        <div class="mt-4 p-4 bg-secondary-100 dark:bg-neutral-800 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-secondary-900 dark:text-white">Dark Mode</h3>
                    <p class="text-sm text-secondary-600 dark:text-neutral-300">Toggle antara light dan dark mode</p>
                </div>
                @include('components.dark-mode-toggle')
            </div>
        </div>
    </div>

    <!-- Color Palette -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Palet Warna</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Primary Colors -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Primary</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-primary-50 rounded-lg">
                            <span class="text-sm font-medium">50</span>
                            <span class="text-xs text-secondary-500">#eff6ff</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-primary-100 rounded-lg">
                            <span class="text-sm font-medium">100</span>
                            <span class="text-xs text-secondary-500">#dbeafe</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-primary-500 text-white rounded-lg">
                            <span class="text-sm font-medium">500</span>
                            <span class="text-xs opacity-75">#3b82f6</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-primary-600 text-white rounded-lg">
                            <span class="text-sm font-medium">600</span>
                            <span class="text-xs opacity-75">#2563eb</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-primary-900 text-white rounded-lg">
                            <span class="text-sm font-medium">900</span>
                            <span class="text-xs opacity-75">#1e3a8a</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Colors -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Secondary</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-secondary-50 rounded-lg">
                            <span class="text-sm font-medium">50</span>
                            <span class="text-xs text-secondary-500">#f8fafc</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-secondary-100 rounded-lg">
                            <span class="text-sm font-medium">100</span>
                            <span class="text-xs text-secondary-500">#f1f5f9</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-secondary-500 text-white rounded-lg">
                            <span class="text-sm font-medium">500</span>
                            <span class="text-xs opacity-75">#64748b</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-secondary-600 text-white rounded-lg">
                            <span class="text-sm font-medium">600</span>
                            <span class="text-xs opacity-75">#475569</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-secondary-900 text-white rounded-lg">
                            <span class="text-sm font-medium">900</span>
                            <span class="text-xs opacity-75">#0f172a</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Colors -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status Colors</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-success-500 text-white rounded-lg">
                            <span class="text-sm font-medium">Success</span>
                            <span class="text-xs opacity-75">#22c55e</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-warning-500 text-white rounded-lg">
                            <span class="text-sm font-medium">Warning</span>
                            <span class="text-xs opacity-75">#f59e0b</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-danger-500 text-white rounded-lg">
                            <span class="text-sm font-medium">Danger</span>
                            <span class="text-xs opacity-75">#ef4444</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-accent-500 text-white rounded-lg">
                            <span class="text-sm font-medium">Accent</span>
                            <span class="text-xs opacity-75">#d946ef</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Typography -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Typography</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="space-y-6">
                    <div>
                        <h1 class="text-6xl font-bold text-secondary-900 mb-2">Heading 1</h1>
                        <code class="text-sm text-secondary-500">text-6xl font-bold</code>
                    </div>
                    <div>
                        <h2 class="text-4xl font-semibold text-secondary-900 mb-2">Heading 2</h2>
                        <code class="text-sm text-secondary-500">text-4xl font-semibold</code>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-secondary-900 mb-2">Heading 3</h3>
                        <code class="text-sm text-secondary-500">text-2xl font-semibold</code>
                    </div>
                    <div>
                        <h4 class="text-xl font-medium text-secondary-900 mb-2">Heading 4</h4>
                        <code class="text-sm text-secondary-500">text-xl font-medium</code>
                    </div>
                    <div>
                        <p class="text-base text-secondary-700 mb-2">Body text - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <code class="text-sm text-secondary-500">text-base text-secondary-700</code>
                    </div>
                    <div>
                        <p class="text-sm text-secondary-600 mb-2">Small text - Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                        <code class="text-sm text-secondary-500">text-sm text-secondary-600</code>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Buttons -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Buttons</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Button Variants -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Button Variants</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex flex-wrap gap-3">
                            <button class="btn-primary">Primary</button>
                            <button class="btn-secondary">Secondary</button>
                            <button class="btn-success">Success</button>
                            <button class="btn-warning">Warning</button>
                            <button class="btn-danger">Danger</button>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button class="btn-ghost">Ghost</button>
                            <button class="btn-outline">Outline</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Sizes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Button Sizes</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <button class="btn btn-sm btn-primary">Small</button>
                            <button class="btn btn-md btn-primary">Medium</button>
                            <button class="btn btn-lg btn-primary">Large</button>
                        </div>
                        <div class="text-sm text-secondary-600">
                            <p><code>.btn-sm</code> - Small button</p>
                            <p><code>.btn-md</code> - Medium button (default)</p>
                            <p><code>.btn-lg</code> - Large button</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Elements -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Form Elements</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="form-label">Input Text</label>
                            <input type="text" class="form-input" placeholder="Enter text...">
                            <p class="form-help">This is a help text</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Select</label>
                            <select class="form-select">
                                <option>Choose option...</option>
                                <option>Option 1</option>
                                <option>Option 2</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Textarea</label>
                            <textarea class="form-textarea" rows="3" placeholder="Enter message..."></textarea>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="form-label">Input with Error</label>
                            <input type="text" class="form-input form-input-error" placeholder="Invalid input">
                            <p class="form-error">This field is required</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Checkboxes</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox">
                                    <span class="ml-2 text-sm text-secondary-700">Option 1</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span class="ml-2 text-sm text-secondary-700">Option 2</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Radio Buttons</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="radio" class="form-radio">
                                    <span class="ml-2 text-sm text-secondary-700">Option A</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="radio" class="form-radio" checked>
                                    <span class="ml-2 text-sm text-secondary-700">Option B</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Cards</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Card Title</h3>
                    <p class="card-subtitle">Card subtitle</p>
                </div>
                <div class="card-body">
                    <p class="text-secondary-700">This is a basic card with header, body, and footer sections. Cards are perfect for displaying content in a structured way.</p>
                </div>
                <div class="card-footer">
                    <div class="flex justify-end gap-2">
                        <button class="btn-secondary btn-sm">Cancel</button>
                        <button class="btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </div>

            <!-- Simple Card -->
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-2">Simple Card</h3>
                    <p class="text-secondary-700 mb-4">This is a simple card with just a body section. Perfect for basic content display.</p>
                    <button class="btn-primary btn-sm">Action</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Badges -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Badges</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="flex flex-wrap gap-3">
                    <span class="badge badge-primary">Primary</span>
                    <span class="badge badge-secondary">Secondary</span>
                    <span class="badge badge-success">Success</span>
                    <span class="badge badge-warning">Warning</span>
                    <span class="badge badge-danger">Danger</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Alerts -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Alerts</h2>
        
        <div class="space-y-4">
            <div class="alert alert-primary">
                <strong>Info!</strong> This is a primary alert message.
            </div>
            <div class="alert alert-success">
                <strong>Success!</strong> Your action was completed successfully.
            </div>
            <div class="alert alert-warning">
                <strong>Warning!</strong> Please check your input before proceeding.
            </div>
            <div class="alert alert-danger">
                <strong>Error!</strong> Something went wrong. Please try again.
            </div>
        </div>
    </section>

    <!-- Loading States -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Loading States</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <div class="spinner spinner-sm mb-2"></div>
                        <p class="text-sm text-secondary-600">Small</p>
                    </div>
                    <div class="text-center">
                        <div class="spinner spinner-md mb-2"></div>
                        <p class="text-sm text-secondary-600">Medium</p>
                    </div>
                    <div class="text-center">
                        <div class="spinner spinner-lg mb-2"></div>
                        <p class="text-sm text-secondary-600">Large</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dark Mode Documentation -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 dark:text-white mb-6">Dark Mode</h2>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dark Mode Implementation</h3>
                <p class="card-subtitle">Sistem dark mode dengan Alpine.js (via Livewire) dan Tailwind CSS</p>
            </div>
            <div class="card-body">
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-semibold text-secondary-900 dark:text-white mb-3">Implementasi</h4>
                        <div class="bg-secondary-100 dark:bg-neutral-800 p-4 rounded-lg">
                            <pre class="text-sm text-secondary-700 dark:text-neutral-300"><code>&lt;!-- Dark Mode Toggle Component --&gt;
@include('components.dark-mode-toggle')

&lt;!-- Dark Mode Classes --&gt;
&lt;div class="bg-white dark:bg-neutral-800"&gt;
  &lt;p class="text-secondary-900 dark:text-white"&gt;Text&lt;/p&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold text-secondary-900 dark:text-white mb-3">Color Mapping</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <h5 class="font-medium text-secondary-900 dark:text-white">Light Mode</h5>
                                <div class="space-y-1 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-white border border-secondary-300 rounded"></div>
                                        <code>bg-white</code>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-secondary-100 rounded"></div>
                                        <code>bg-secondary-100</code>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-secondary-900 rounded"></div>
                                        <code>text-secondary-900</code>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h5 class="font-medium text-secondary-900 dark:text-white">Dark Mode</h5>
                                <div class="space-y-1 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-neutral-800 rounded"></div>
                                        <code>dark:bg-neutral-800</code>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-neutral-900 rounded"></div>
                                        <code>dark:bg-neutral-900</code>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-white rounded"></div>
                                        <code>dark:text-white</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Spacing -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Spacing Scale</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 text-sm text-secondary-600">xs (0.5rem)</div>
                        <div class="h-4 bg-primary-200" style="width: 0.5rem;"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-16 text-sm text-secondary-600">sm (0.75rem)</div>
                        <div class="h-4 bg-primary-200" style="width: 0.75rem;"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-16 text-sm text-secondary-600">md (1rem)</div>
                        <div class="h-4 bg-primary-200" style="width: 1rem;"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-16 text-sm text-secondary-600">lg (1.5rem)</div>
                        <div class="h-4 bg-primary-200" style="width: 1.5rem;"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-16 text-sm text-secondary-600">xl (2rem)</div>
                        <div class="h-4 bg-primary-200" style="width: 2rem;"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-16 text-sm text-secondary-600">2xl (3rem)</div>
                        <div class="h-4 bg-primary-200" style="width: 3rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Usage Examples -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-secondary-900 mb-6">Usage Examples</h2>
        
        <div class="space-y-6">
            <!-- Code Examples -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">CSS Classes</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-secondary-700 mb-2">Button Primary</h4>
                            <code class="block p-3 bg-secondary-100 rounded text-sm">&lt;button class="btn-primary"&gt;Click me&lt;/button&gt;</code>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-secondary-700 mb-2">Form Input</h4>
                            <code class="block p-3 bg-secondary-100 rounded text-sm">&lt;input type="text" class="form-input" placeholder="Enter text..."&gt;</code>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-secondary-700 mb-2">Card</h4>
                            <code class="block p-3 bg-secondary-100 rounded text-sm">&lt;div class="card"&gt;&lt;div class="card-body"&gt;Content&lt;/div&gt;&lt;/div&gt;</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection