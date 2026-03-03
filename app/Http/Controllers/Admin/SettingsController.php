<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => Setting::get('company_name', 'Car Wash POS'),
            'company_address' => Setting::get('company_address', "123 Street Name,\nCity, State, 12345"),
            'company_logo' => Setting::get('company_logo'),
            'currency_symbol' => Setting::get('currency_symbol', 'RM'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_logo' => 'nullable|image|max:2048',
            'currency_symbol' => 'required|string|max:10',
        ]);

        Setting::set('company_name', $request->company_name);
        Setting::set('company_address', $request->company_address);
        Setting::set('currency_symbol', $request->currency_symbol);

        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('company_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('company_logo')->store('logos', 'public');
            Setting::set('company_logo', $path);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
