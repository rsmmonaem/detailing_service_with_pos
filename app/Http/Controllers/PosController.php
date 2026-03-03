<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Setting;
use App\Models\Service;
use App\Models\QrCode;

class PosController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => Setting::get('company_name', 'Car Wash POS'),
            'company_address' => Setting::get('company_address', '123 Street Name'),
            'company_logo' => Setting::get('company_logo'),
            'currency_symbol' => Setting::get('currency_symbol', 'RM'),
        ];
        
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $activeQr = QrCode::where('is_active', true)->first();

        return view('pos', compact('settings', 'services', 'activeQr'));
    }

    public function store(Request $request)
    {
        $serviceNames = Service::where('is_active', true)->pluck('name')->toArray();
        $serviceNamesStr = implode(',', $serviceNames);

        $validated = $request->validate([
            'license_plate' => 'required|string',
            'customer_mobile' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'note' => 'nullable|string',
            'service_type' => 'required|in:' . $serviceNamesStr,
            'amount' => 'required|numeric|min:1|max:100000',
            'payment_method' => 'required|in:Cash,QR',
        ]);

        $sale = Sale::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sale recorded successfully.',
            'sale' => $sale,
            'receipt' => $this->generateReceipt($sale),
        ]);
    }

    private function generateReceipt($sale)
    {
        $settings = [
            'company_name' => Setting::get('company_name', 'Car Wash POS'),
            'company_address' => Setting::get('company_address', '123 Street Name'),
            'company_logo' => Setting::get('company_logo'),
            'currency_symbol' => Setting::get('currency_symbol', 'RM'),
        ];

        return [
            'company_name' => $settings['company_name'],
            'company_address' => $settings['company_address'],
            'company_logo' => $settings['company_logo'],
            'currency_symbol' => $settings['currency_symbol'],
            'date' => $sale->created_at->format('Y-m-d H:i:s'),
            'license_plate' => $sale->license_plate,
            'service_type' => $sale->service_type,
            'amount' => $sale->amount,
            'payment_method' => $sale->payment_method,
            'customer_mobile' => $sale->customer_mobile,
            'customer_name' => $sale->customer_name,
        ];
    }
}
