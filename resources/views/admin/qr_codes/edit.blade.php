<x-admin-layout>
    @section('title', 'Edit QR Code')

    <div class="max-w-2xl bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.qr_codes.update', $qrCode) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Account Name / Label</label>
                <input type="text" name="name" value="{{ old('name', $qrCode->name) }}" required 
                       class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Change QR Code Image (Optional)</label>
                <div class="flex items-center gap-6 mb-4">
                    <div class="w-24 h-24 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-center p-2">
                        <img src="{{ asset('storage/' . $qrCode->image_path) }}" alt="Current QR" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="flex-1">
                        <input type="file" name="image" accept="image/*"
                               class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">
                    </div>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $qrCode->is_active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Set as Active (The POS will use the active QR code)</label>
            </div>

            <div class="pt-6 border-t border-slate-50 flex gap-4">
                <button type="submit" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition active:scale-95">
                    Update & Save
                </button>
                <a href="{{ route('admin.qr_codes.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
