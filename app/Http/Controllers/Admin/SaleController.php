<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        if ($request->filled('mobile')) {
            $query->where('customer_mobile', 'like', '%' . $request->mobile . '%');
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $settings = [
            'company_name' => \App\Models\Setting::get('company_name', 'Car Wash POS'),
            'company_address' => \App\Models\Setting::get('company_address', '123 Street Name, City, State'),
            'company_logo' => \App\Models\Setting::get('company_logo'),
            'currency_symbol' => \App\Models\Setting::get('currency_symbol', 'RM'),
        ];

        return view('admin.sales.index', compact('sales', 'settings'));
    }

    public function export(Request $request)
    {
        $query = Sale::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        if ($request->filled('mobile')) {
            $query->where('customer_mobile', 'like', '%' . $request->mobile . '%');
        }

        $sales = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=sales_export_" . date('Ymd') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Date', 'Plate', 'Service', 'Amount', 'Method', 'Mobile', 'Name', 'Note'];

        $callback = function() use($sales, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->id,
                    $sale->created_at->format('Y-m-d H:i:s'),
                    $sale->license_plate,
                    $sale->service_type,
                    $sale->amount,
                    $sale->payment_method,
                    $sale->customer_mobile,
                    $sale->customer_name,
                    $sale->note
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
