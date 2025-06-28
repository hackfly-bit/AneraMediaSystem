<div>
    <!-- Preview Button -->
    <button wire:click="openPreview" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        Preview
    </button>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closePreview"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-6 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Invoice Preview - {{ $invoice->invoice_number }}
                        </h3>
                        <div class="flex space-x-2">
                            <button wire:click="downloadPdf" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download PDF
                            </button>
                            <button wire:click="closePreview" class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Close
                            </button>
                        </div>
                    </div>

                    <!-- Invoice Preview Content -->
                    <div class="bg-white border border-gray-200 rounded-lg p-8 max-h-96 overflow-y-auto">
                        <!-- Invoice Header -->
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">INVOICE</h1>
                                <p class="text-gray-600">Invoice #{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="text-right">
                                <h2 class="text-xl font-semibold text-gray-900 mb-2">Your Company Name</h2>
                                <p class="text-gray-600">123 Business Street</p>
                                <p class="text-gray-600">City, State 12345</p>
                                <p class="text-gray-600">contact@company.com</p>
                            </div>
                        </div>

                        <!-- Client and Invoice Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Bill To:</h3>
                                <div class="text-gray-700">
                                    <p class="font-medium">{{ $invoice->client->name }}</p>
                                    @if($invoice->client->company)
                                        <p>{{ $invoice->client->company }}</p>
                                    @endif
                                    <p>{{ $invoice->client->email }}</p>
                                    @if($invoice->client->phone)
                                        <p>{{ $invoice->client->phone }}</p>
                                    @endif
                                    @if($invoice->client->address)
                                        <p>{{ $invoice->client->address }}</p>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Invoice Details:</h3>
                                <div class="text-gray-700 space-y-1">
                                    <div class="flex justify-between">
                                        <span>Issue Date:</span>
                                        <span>{{ $invoice->issue_date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Due Date:</span>
                                        <span>{{ $invoice->due_date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Status:</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($invoice->status == 'paid') bg-green-100 text-green-800
                                            @elseif($invoice->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($invoice->status == 'overdue') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </div>
                                    @if($invoice->project)
                                        <div class="flex justify-between">
                                            <span>Project:</span>
                                            <span>{{ $invoice->project->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Items -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Items:</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($invoice->invoiceItems as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->description }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $item->quantity }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 text-right">Rp. {{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 text-right font-medium">Rp. {{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Invoice Totals -->
                        <div class="flex justify-end">
                            <div class="w-64">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span>Subtotal:</span>
                                        <span>Rp. {{ number_format($invoice->invoiceItems->sum('total_price'), 2) }}</span>
                                    </div>
                                    @if($invoice->tax > 0)
                                    <div class="flex justify-between text-sm">
                                        <span>Tax:</span>
                                        <span>Rp. {{ number_format($invoice->tax, 2) }}</span>
                                    </div>
                                    @endif
                                    @if($invoice->discount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span>Discount:</span>
                                        <span>-Rp. {{ number_format($invoice->discount, 2) }}</span>
                                    </div>
                                    @endif
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between text-lg font-semibold">
                                            <span>Total:</span>
                                            <span>Rp. {{ number_format($invoice->total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($invoice->notes)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Notes:</h3>
                            <p class="text-gray-700">{{ $invoice->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
