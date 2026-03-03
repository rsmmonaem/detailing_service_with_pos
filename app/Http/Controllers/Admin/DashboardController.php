<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        $stats = [
            'daily' => Sale::whereDate('created_at', $today)->sum('amount'),
            'weekly' => Sale::whereBetween('created_at', [$thisWeek, Carbon::now()])->sum('amount'),
            'monthly' => Sale::whereBetween('created_at', [$thisMonth, Carbon::now()])->sum('amount'),
            'total_cars' => Sale::count(),
            'total_cash' => Sale::where('payment_method', 'Cash')->sum('amount'),
            'total_qr' => Sale::where('payment_method', 'QR')->sum('amount'),
        ];

        // Sales for chart (last 30 days) - Fill missing dates with 0
        $rawChartData = Sale::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $chartData[] = [
                'date' => Carbon::parse($date)->format('M d'),
                'total' => $rawChartData[$date] ?? 0
            ];
        }

        return view('admin.dashboard', compact('stats', 'chartData'));
    }

    public function dailyReport(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        
        $sales = Sale::whereDate('created_at', $date)->get();
        
        $summary = [
            'date' => $date,
            'total_cars' => $sales->count(),
            'total_cash' => $sales->where('payment_method', 'Cash')->sum('amount'),
            'total_qr' => $sales->where('payment_method', 'QR')->sum('amount'),
            'total_sales' => $sales->sum('amount'),
        ];

        return view('admin.reports.daily', compact('summary', 'sales'));
    }
}
