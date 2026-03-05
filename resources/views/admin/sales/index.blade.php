<x-admin-layout>
    <div x-data="{ 
        showModal: false, 
        sale: null,
        settings: {{ json_encode($settings) }},
        printInvoice() {
            window.print();
        }
    }">

    <style>
        @media print {
            .no-print, aside, header, nav, button, .modal-header { display: none !important; }
            body, main { background: white !important; padding: 0 !important; margin: 0 !important; }
            #receipt-print { 
                border: none !important; 
                box-shadow: none !important; 
                width: 100% !important; 
                max-width: 57mm !important; 
                margin: 0 auto !important; 
                padding: 0 !important; 
                font-family: monospace !important; 
                font-size: 10px !important; 
                display: block !important;
            }
            #receipt-print h3 { font-size: 14px !important; }
            #receipt-print .bg-blue-50 { background: transparent !important; color: black !important; border-top: 1px dashed black !important; border-bottom: 1px dashed black !important; margin: 10px 0 !important; padding: 10px 0 !important; }
            #receipt-print .text-slate-500, #receipt-print .text-slate-400 { color: black !important; }
            
            /* Modal overrides to show content only */
            .fixed.inset-0 { position: static !important; display: block !important; background: transparent !important; padding: 0 !important; backdrop-filter: none !important; }
            .bg-white.rounded-3xl.w-full.max-w-sm { max-width: 100% !important; box-shadow: none !important; border-radius: 0 !important; background: transparent !important; }
            .p-6.bg-slate-100 { background: transparent !important; padding: 0 !important; max-height: none !important; overflow: visible !important; }
        }
    </style>
    @section('title', 'Sales History')

    <!-- Filters -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 no-print">
        <form action="{{ route('admin.sales.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Mobile Number</label>
                <input type="text" name="mobile" value="{{ request('mobile') }}" placeholder="Search mobile..."
                       class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition active:scale-95">
                    Filter
                </button>
                <a href="{{ route('admin.sales.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden no-print">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">All Transactions</h3>
            <a href="{{ route('admin.sales.export', request()->all()) }}" class="flex items-center text-sm font-bold text-green-600 hover:text-green-700 bg-green-50 px-4 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Export CSV
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Date & Time</th>
                        <th class="px-6 py-4">Plate No</th>
                        <th class="px-6 py-4">Service</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Method</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="px-6 py-4 text-sm text-slate-500">#{{ $sale->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-700">{{ $sale->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm"><span class="bg-slate-100 px-3 py-1 rounded-md font-bold text-slate-800 uppercase">{{ $sale->license_plate }}</span></td>
                        <td class="px-6 py-4 text-sm"><span class="px-2 py-1 rounded-full text-xs font-bold {{ $sale->service_type === 'Car Wash' ? 'bg-blue-100 text-blue-700' : ($sale->service_type === 'Polish' ? 'bg-indigo-100 text-indigo-700' : 'bg-purple-100 text-purple-700') }}">{{ $sale->service_type }}</span></td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $settings['currency_symbol'] }} {{ number_format($sale->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="flex items-center text-xs font-bold uppercase {{ $sale->payment_method === 'Cash' ? 'text-green-600' : 'text-blue-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $sale->payment_method === 'Cash' ? 'bg-green-600' : 'bg-blue-600' }}"></span>
                                {{ $sale->payment_method }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-700">{{ $sale->customer_name ?: 'N/A' }}</span>
                                <span class="text-xs text-slate-400">{{ $sale->customer_mobile ?: '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <button @click="sale = {{ $sale->toJson() }}; showModal = true" class="text-blue-600 hover:text-blue-800 font-bold flex items-center bg-blue-50 px-3 py-1.5 rounded-lg transition active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Invoice
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-400">No sales records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
            {{ $sales->links() }}
        </div>
        @endif
    </div>

    <!-- Invoice Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden flex flex-col shadow-2xl relative"
             x-transition:enter="transition ease-out duration-300 transform scale-95" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
            
            <div class="p-4 border-b flex justify-between items-center bg-slate-50 modal-header">
                <h3 class="font-bold text-slate-800">Review Invoice</h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" /></svg>
                </button>
            </div>

            <div class="p-6 bg-slate-100 overflow-y-auto max-h-[70vh]">
                <div id="receipt-print" class="bg-white p-6 shadow-sm mx-auto w-full max-w-[280px] font-mono text-[11px] leading-tight text-black border-t-4 border-slate-200" x-if="sale">
                    <div class="text-center mb-4">
                         <template x-if="settings.company_logo">
                            <img :src="'/storage/' + settings.company_logo" alt="Logo" class="h-12 w-12 mx-auto mb-2 object-contain">
                        </template>
                        <h3 class="text-lg font-bold uppercase" x-text="settings.company_name"></h3>
                        <p class="whitespace-pre-line text-gray-700" x-text="settings.company_address"></p>
                        <div class="my-2 border-b border-dashed border-gray-400"></div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between"><span>Date:</span><span x-text="new Date(sale.created_at).toLocaleString()"></span></div>
                        <div class="flex justify-between"><span>Plate:</span><span class="font-bold underline" x-text="sale.license_plate"></span></div>
                        <template x-if="sale.customer_name">
                            <div class="flex justify-between"><span>Name:</span><span x-text="sale.customer_name"></span></div>
                        </template>
                        <template x-if="sale.customer_mobile">
                            <div class="flex justify-between"><span>Mobile:</span><span x-text="sale.customer_mobile"></span></div>
                        </template>
                    </div>

                    <div class="my-2 border-b border-dashed border-gray-400"></div>

                    <div class="space-y-2">
                        <div class="flex justify-between font-bold text-sm">
                            <span x-text="sale.service_type"></span>
                            <span><span x-text="settings.currency_symbol || 'RM'"></span> <span x-text="Number(sale.amount).toFixed(2)"></span></span>
                        </div>
                    </div>

                    <div class="my-2 border-b border-dashed border-gray-400"></div>

                    <div class="flex justify-between font-black text-base">
                        <span>TOTAL:</span>
                        <span><span x-text="settings.currency_symbol || 'RM'"></span> <span x-text="Number(sale.amount).toFixed(2)"></span></span>
                    </div>

                    <div class="mt-2 flex justify-between italic">
                        <span>Paid via:</span>
                        <span x-text="sale.payment_method"></span>
                    </div>

                    <div class="text-center mt-6">
                        <div class="my-2 border-b border-dashed border-gray-400"></div>
                        <p class="text-sm font-bold">THANK YOU!</p>
                        <p class="text-[9px] text-gray-500 mt-1">Please come again</p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white border-t">
                <button @click="printInvoice()" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold flex items-center justify-center shadow-lg active:scale-95 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Print Receipt
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Print Frame -->
    <iframe id="print-iframe" class="hidden"></iframe>
    </div>
</x-admin-layout>
