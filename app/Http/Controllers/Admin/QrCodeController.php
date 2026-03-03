<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    public function index()
    {
        $qrCodes = QrCode::all();
        return view('admin.qr_codes.index', compact('qrCodes'));
    }

    public function create()
    {
        return view('admin.qr_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $path = $request->file('image')->store('qr_codes', 'public');

        // Deactivate other QR codes if this one is active
        if ($request->is_active) {
            QrCode::where('is_active', true)->update(['is_active' => false]);
        }

        QrCode::create([
            'name' => $request->name,
            'image_path' => $path,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.qr_codes.index')->with('success', 'QR Code uploaded successfully.');
    }

    public function edit(QrCode $qrCode)
    {
        return view('admin.qr_codes.edit', compact('qrCode'));
    }

    public function update(Request $request, QrCode $qrCode)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($qrCode->image_path);
            $qrCode->image_path = $request->file('image')->store('qr_codes', 'public');
        }

        if ($request->is_active && !$qrCode->is_active) {
            QrCode::where('is_active', true)->update(['is_active' => false]);
        }

        $qrCode->name = $request->name;
        $qrCode->is_active = $request->is_active ?? false;
        $qrCode->save();

        return redirect()->route('admin.qr_codes.index')->with('success', 'QR Code updated successfully.');
    }

    public function destroy(QrCode $qrCode)
    {
        Storage::disk('public')->delete($qrCode->image_path);
        $qrCode->delete();
        return redirect()->route('admin.qr_codes.index')->with('success', 'QR Code deleted successfully.');
    }
}
