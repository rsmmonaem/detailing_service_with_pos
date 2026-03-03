<x-admin-layout>
    @section('title', 'System Settings')

    <div class="max-w-2xl">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 mb-8">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Company Profile</h3>
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Company Name</label>
                        <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name']) }}" 
                               class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">
                        @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Currency Symbol</label>
                        <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol']) }}" 
                               class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium"
                               placeholder="e.g. RM, $, £, €">
                        @error('currency_symbol') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Address (Thermal Receipt Format)</label>
                    <textarea name="company_address" rows="3" 
                              class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition font-medium">{{ old('company_address', $settings['company_address']) }}</textarea>
                    <p class="text-slate-400 text-xs mt-1">Tip: Use short lines for 57mm thermal printing.</p>
                    @error('company_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Company Logo</label>
                    <div class="flex items-start gap-6">
                        <div class="w-24 h-24 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center bg-slate-50 overflow-hidden group relative">
                            @if($settings['company_logo'])
                                <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo" class="w-full h-full object-contain">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="company_logo" id="logo_input" class="hidden" accept="image/*">
                            <label for="logo_input" class="inline-block px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold cursor-pointer hover:bg-slate-200 transition mb-2">
                                Choose Image
                            </label>
                            <p class="text-slate-400 text-xs">Recommended: Square logo, max 2MB. Logos are automatically converted for thermal orientation.</p>
                        </div>
                    </div>
                    @error('company_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition active:scale-95">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-blue-600 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
             <div class="absolute -right-10 -bottom-10 opacity-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-48 w-48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
             </div>
             <h4 class="text-lg font-bold mb-2">Thermal Print Optimization</h4>
             <p class="text-blue-100 text-sm leading-relaxed mb-6">We've optimized the receipt generator for 57mm/58mm thermal printers. Make sure your printer is set to its native resolution for the best output.</p>
             <button @click="window.open('/', '_blank')" class="px-6 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-sm font-bold transition flex items-center backdrop-blur-sm">
                 Test POS View
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
             </button>
        </div>
    </div>
</x-admin-layout>
