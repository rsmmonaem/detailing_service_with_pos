<x-admin-layout>
    @section('title', 'Add New Service')

    <div class="max-w-2xl bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Service Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., Premium Wax" 
                       class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Default Amount ({{ \App\Models\Setting::get('currency_symbol', 'RM') }})</label>
                <input type="number" name="default_amount" value="{{ old('default_amount') }}" required min="0" step="0.01" placeholder="0.00" 
                       class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">
                @error('default_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Icon / Category</label>
                <select name="icon" class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">
                    <option value="Car Wash">Car Wash (Standard Icon)</option>
                    <option value="Polish">Polish (Sparkle Icon)</option>
                    <option value="Tinted">Tinted (Shield Icon)</option>
                    <option value="Other">Other (Box Icon)</option>
                </select>
                @error('icon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Set as Active</label>
            </div>

            <div class="pt-6 border-t border-slate-50 flex gap-4">
                <button type="submit" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition active:scale-95">
                    Save Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
