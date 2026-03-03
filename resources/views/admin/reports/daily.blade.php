<x-admin-layout>
    @section('title', 'Daily Summary Report')

    <div class="max-w-md mx-auto">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 no-print">
            <form action="{{ route('admin.reports.daily') }}" method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Select Date</label>
                    <input type="date" name="date" value="{{ $summary['date'] }}" 
                           class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
                </div>
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition">
                    Go
                </button>
            </form>
        </div>

        <!-- Printable Report -->
        <div id="summary-report" class="bg-white p-8 shadow-sm rounded-3xl border border-slate-100 text-slate-800">
            <div class="text-center mb-6">
                <h3 class="text-xl font-black uppercase tracking-tight">Daily Summary</h3>
                <p class="text-slate-500 font-bold">{{ \Carbon\Carbon::parse($summary['date'])->format('l, d M Y') }}</p>
                <div class="h-1 w-12 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="space-y-4 mb-8">
                <div class="flex justify-between items-center py-3 border-b border-slate-50 text-slate-600">
                    <span class="font-medium">Total Cars / Services</span>
                    <span class="font-black text-slate-900 text-lg">{{ $summary['total_cars'] }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50 text-slate-600">
                    <span class="font-medium">Cash Collected</span>
                    <span class="font-bold text-slate-900">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($summary['total_cash'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50 text-slate-600">
                    <span class="font-medium">QR / E-Wallet</span>
                    <span class="font-bold text-slate-900">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($summary['total_qr'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center py-6 text-blue-600 bg-blue-50 -mx-8 px-8 border-y border-blue-100">
                    <span class="text-xs font-black uppercase tracking-widest">Total Daily Revenue</span>
                    <span class="text-2xl font-black">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($summary['total_sales'], 2) }}</span>
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Transaction Details</h4>
                <div class="space-y-2">
                    @forelse($sales as $sale)
                    <div class="flex justify-between items-center text-xs">
                         <span class="text-slate-500">{{ $sale->created_at->format('H:i') }} | <span class="font-bold uppercase text-slate-700">{{ $sale->license_plate }}</span></span>
                         <span class="font-bold">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($sale->amount, 2) }}</span>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm py-4 italic">No transactions for this date.</p>
                    @endforelse
                </div>
            </div>

            <div class="text-center text-[10px] text-slate-400 border-t border-slate-100 pt-6">
                <p>Report generated on {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>

        <div class="mt-8 no-print">
            <button onclick="window.print()" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold flex items-center justify-center shadow-lg active:scale-95 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Print Report
            </button>
        </div>
    </div>

    <style>
        @media print {
            .no-print, aside, header { display: none !important; }
            body, main { background: white !important; padding: 0 !important; }
            #summary-report { border: none !important; box-shadow: none !important; width: 100% !important; max-width: 57mm !important; margin: 0 auto !important; padding: 0 !important; font-family: monospace !important; font-size: 10px !important; }
            #summary-report h3 { font-size: 14px !important; }
            #summary-report .bg-blue-50 { background: transparent !important; color: black !important; border-top: 1px dashed black !important; border-bottom: 1px dashed black !important; margin: 10px 0 !important; padding: 10px 0 !important; }
            #summary-report .text-slate-500, #summary-report .text-slate-400 { color: black !important; }
        }
    </style>
</x-admin-layout>
