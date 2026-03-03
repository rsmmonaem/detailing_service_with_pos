<x-admin-layout>
    @section('title', 'QR Code Management')

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-slate-800">QR Codes</h3>
            <p class="text-slate-500 text-sm">Manage QR codes for customer payments.</p>
        </div>
        <a href="{{ route('admin.qr_codes.create') }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Upload New QR
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($qrCodes as $qrCode)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden group">
                <div class="aspect-square bg-slate-50 flex items-center justify-center p-8 relative">
                    <img src="{{ asset('storage/' . $qrCode->image_path) }}" alt="{{ $qrCode->name }}" class="max-w-full max-h-full object-contain shadow-md">
                    @if($qrCode->is_active)
                        <div class="absolute top-4 right-4 bg-green-500 text-white text-[10px] font-black uppercase px-2 py-1 rounded-full shadow-sm">
                            Active
                        </div>
                    @endif
                </div>
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-800">{{ $qrCode->name }}</p>
                        <p class="text-xs text-slate-400">{{ $qrCode->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.qr_codes.edit', $qrCode) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="{{ route('admin.qr_codes.destroy', $qrCode) }}" method="POST" onsubmit="return confirm('Delete this QR code?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-20 text-center bg-white rounded-3xl border border-slate-100">
                <p class="text-slate-400 font-medium">No QR codes found. Upload your first one to use in the POS.</p>
                <a href="{{ route('admin.qr_codes.create') }}" class="inline-block mt-4 text-blue-600 font-bold hover:underline">Upload QR Code</a>
            </div>
        @endforelse
    </div>
</x-admin-layout>
