<x-admin-layout>
    @section('title', isset($permission) ? 'Edit Permission' : 'Create Permission')

    <div class="max-w-2xl mx-auto">
        <div class="mb-12">
            <a href="{{ route('admin.permissions.index') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 hover:text-slate-600 mb-4 inline-block transition">
                ← Return to Registry
            </a>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">{{ isset($permission) ? 'Refine Identity' : 'Define Capability' }}</h1>
        </div>

        <div class="bg-white p-12 rounded-[3rem] shadow-2xl shadow-slate-200 border border-slate-100">
            <form action="{{ isset($permission) ? route('admin.permissions.update', $permission) : route('admin.permissions.store') }}" method="POST">
                @csrf
                @if(isset($permission)) @method('PUT') @endif

                <div class="mb-12">
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-blue-600 mb-6">Capability Name</label>
                    <input type="text" name="name" value="{{ old('name', $permission->name ?? '') }}" required autofocus placeholder="e.g. view_reports"
                           class="w-full p-6 bg-slate-50 border-2 border-slate-50 rounded-3xl focus:bg-white focus:border-blue-500 transition duration-300 text-xl font-bold text-slate-800 placeholder-slate-200">
                    <p class="mt-4 text-[10px] text-slate-400 font-medium italic">Lowercase, using underscores as separators is recommended (e.g. delete_transactions)</p>
                    @error('name') <p class="text-red-500 text-xs mt-4 font-bold">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] shadow-xl hover:bg-slate-800 transition active:scale-[0.98]">
                    {{ isset($permission) ? 'Update Registry' : 'Confirm Registration' }}
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
