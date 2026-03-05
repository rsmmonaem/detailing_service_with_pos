<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Transaction Report - {{ $settings['company_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: white; color: #1e293b; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-slate-900 pb-8 mb-8">
            <div class="flex items-center gap-4">
                @if($settings['company_logo'])
                    <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo" class="h-16 w-16 object-contain">
                @endif
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tighter">{{ $settings['company_name'] }}</h1>
                    <p class="text-slate-500 font-medium whitespace-pre-line">{{ $settings['company_address'] }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-slate-900 text-white px-4 py-2 rounded-lg mb-2">
                    <p class="text-xs font-black uppercase tracking-widest">Report Date</p>
                    <p class="text-xl font-bold">{{ \Carbon\Carbon::parse($summary['date'])->format('d M Y') }}</p>
                </div>
                <p class="text-[10px] text-slate-400 font-medium">Generated: {{ now()->format('d/m/Y H:i A') }}</p>
            </div>
        </div>

        <h2 class="text-xl font-black uppercase tracking-widest text-slate-900 mb-6 flex items-center">
            <span class="w-8 h-1 bg-slate-900 mr-4"></span>
            Daily Transaction Log
        </h2>

        <!-- Transactions Table -->
        <table class="w-full mb-12 border-collapse">
            <thead>
                <tr class="border-b-2 border-slate-200 text-left">
                    <th class="py-4 text-xs font-black uppercase tracking-widest text-slate-400">Time</th>
                    <th class="py-4 text-xs font-black uppercase tracking-widest text-slate-400">Plate No</th>
                    <th class="py-4 text-xs font-black uppercase tracking-widest text-slate-400">Service</th>
                    <th class="py-4 text-xs font-black uppercase tracking-widest text-slate-400">Method</th>
                    <th class="py-4 text-right text-xs font-black uppercase tracking-widest text-slate-400">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 italic">
                @foreach($sales as $sale)
                <tr>
                    <td class="py-4 text-sm font-medium">{{ $sale->created_at->format('H:i') }}</td>
                    <td class="py-4 text-sm font-bold uppercase">{{ $sale->license_plate }}</td>
                    <td class="py-4 text-sm text-slate-600">{{ $sale->service_type }}</td>
                    <td class="py-4 text-sm">
                        <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $sale->payment_method === 'Cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $sale->payment_method }}
                        </span>
                    </td>
                    <td class="py-4 text-sm font-black text-right">{{ $settings['currency_symbol'] }} {{ number_format($sale->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="grid grid-cols-2 gap-12 border-t-2 border-slate-900 pt-12">
            <div>
                <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Financial breakdown</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm font-medium text-slate-600">
                        <span>Total Cash Transactions</span>
                        <span class="font-bold text-slate-900">{{ $settings['currency_symbol'] }} {{ number_format($summary['cash_amount'], 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-medium text-slate-600">
                        <span>Total QR Transactions</span>
                        <span class="font-bold text-slate-900">{{ $settings['currency_symbol'] }} {{ number_format($summary['qr_amount'], 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-t-2 border-slate-100 mt-4 h-16 bg-slate-50 -mx-6 px-6">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-900">Gross Total Revenue</span>
                        <span class="text-2xl font-black text-slate-900">{{ $settings['currency_symbol'] }} {{ number_format($summary['total_amount'], 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-between">
                <div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Operational Summary</h3>
                    <div class="p-6 bg-slate-900 text-white rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-wider opacity-60">Total Vehicles</p>
                            <p class="text-4xl font-black">{{ $summary['total_count'] }}</p>
                        </div>
                        <div class="h-12 w-12 border-2 border-white/20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                    </div>
                </div>
                
                <!-- Signatures -->
                <div class="pt-12 grid grid-cols-2 gap-8 text-center">
                    <div class="border-t border-slate-300 pt-2">
                        <p class="text-[10px] font-black uppercase tracking-widest">Supervisor</p>
                    </div>
                    <div class="border-t border-slate-300 pt-2">
                        <p class="text-[10px] font-black uppercase tracking-widest">Admin</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-24 text-center border-t border-slate-100 pt-8 no-print">
            <button onclick="window.print()" class="bg-slate-900 text-white px-12 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-slate-800 transition active:scale-95">
                Print Official Report
            </button>
        </div>
    </div>
</body>
</html>
