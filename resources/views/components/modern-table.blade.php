@props([
    'headers' => [],
    'striped' => true,
    'hoverable' => true,
    'responsive' => true
])

<div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-200 dark:border-neutral-700 overflow-hidden">
    @if($responsive)
        <div class="overflow-x-auto">
    @endif
    
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        @if(!empty($headers))
            <thead class="bg-gray-50 dark:bg-neutral-900">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif
        
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-gray-200 dark:divide-neutral-700">
            {{ $slot }}
        </tbody>
    </table>
    
    @if($responsive)
        </div>
    @endif
</div>

@push('styles')
<style>
    .modern-table-row {
        @apply transition-colors duration-200;
    }
    
    @if($hoverable)
        .modern-table-row:hover {
            @apply bg-gray-50 dark:bg-neutral-700;
        }
    @endif
    
    @if($striped)
        .modern-table-row:nth-child(even) {
            @apply bg-gray-25 dark:bg-neutral-800;
        }
    @endif
</style>
@endpush