<x-admin-layout>
    @section('title', 'Dashboard Overview')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <!-- Daily Sales -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium">Daily Sales</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($stats['daily'], 2) }}</h3>
            </div>
        </div>

        <!-- Weekly Sales -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium">Weekly Sales</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($stats['weekly'], 2) }}</h3>
            </div>
        </div>

        <!-- Monthly Sales -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium">Monthly Sales</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($stats['monthly'], 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Sales Chart -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h4 class="text-xl font-bold text-slate-800 tracking-tight">Revenue Trend</h4>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Last 30 Days</p>
                </div>
                <div class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase rounded-full tracking-widest">
                    Live
                </div>
            </div>
            <div class="h-[300px] w-full relative">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Payment Breakdown -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="text-lg font-bold text-slate-800 mb-6">Payment Methods</h4>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-semibold text-slate-600">Cash</span>
                        <span class="font-bold text-slate-800">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($stats['total_cash'], 2) }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($stats['total_cash'] + $stats['total_qr']) > 0 ? ($stats['total_cash'] / ($stats['total_cash'] + $stats['total_qr'])) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-semibold text-slate-600">QR / E-Wallet</span>
                        <span class="font-bold text-slate-800">{{ \App\Models\Setting::get('currency_symbol', 'RM') }} {{ number_format($stats['total_qr'], 2) }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($stats['total_cash'] + $stats['total_qr']) > 0 ? ($stats['total_qr'] / ($stats['total_cash'] + $stats['total_qr'])) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-10 p-6 bg-slate-50 rounded-2xl flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase mb-1">Total Orders</p>
                    <p class="text-2xl font-black text-slate-900">{{ $stats['total_cars'] }}</p>
                </div>
                <a href="{{ route('admin.sales.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold text-blue-600 shadow-sm hover:shadow-md transition">
                    View All
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        <h4 class="text-lg font-bold text-slate-800 mb-6">Reports & Actions</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
             <a href="{{ route('admin.reports.daily') }}" class="p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center mb-3 shadow-sm text-blue-600 group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                </div>
                <p class="font-bold text-slate-800">Daily Summary</p>
                <p class="text-xs text-slate-500 mt-1">Print today's report</p>
            </a>

             <a href="{{ route('admin.sales.export') }}" class="p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-green-200 hover:bg-green-50 transition group">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center mb-3 shadow-sm text-green-600 group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                </div>
                <p class="font-bold text-slate-800">Export Sales</p>
                <p class="text-xs text-slate-500 mt-1">Download CSV records</p>
            </a>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const data = @json($chartData);
            
            // Create gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.005)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Revenue',
                        data: data.map(d => d.total),
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        tension: 0.45,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 3,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#2563eb',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 16,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 14, weight: 'medium' },
                            cornerRadius: 16,
                            displayColors: false,
                            borderWidth: 1,
                            borderColor: 'rgba(255,255,255,0.1)',
                            callbacks: {
                                label: function(context) {
                                    return 'RM ' + context.parsed.y.toLocaleString(undefined, {minimumFractionDigits: 2});
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { 
                                color: '#f1f5f9',
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: { 
                                color: '#94a3b8',
                                font: { size: 11, weight: 'medium' },
                                padding: 10,
                                callback: function(value) { return 'RM ' + value; }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                color: '#94a3b8',
                                font: { size: 10, weight: 'bold' },
                                padding: 10,
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>
