<x-admin-layout>
    @section('title', isset($user) ? 'Edit User' : 'Create User')

    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="text-slate-400 hover:text-slate-600 flex items-center text-sm font-bold mb-4 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                Back to Users
            </a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ isset($user) ? 'Modify Associate' : 'Onboard New Staff' }}</h1>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="p-8 lg:p-12">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div class="space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-blue-600 mb-6">Personal Identity</h3>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                                   class="w-full p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition duration-300 font-medium">
                            @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                                   class="w-full p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition duration-300 font-medium tracking-tight">
                            @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-blue-600 mb-6">Security & Access</h3>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password {{ isset($user) ? '(Leave blank to keep current)' : '' }}</label>
                            <input type="password" name="password" {{ isset($user) ? '' : 'required' }}
                                   class="w-full p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition duration-300 font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }}
                                   class="w-full p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition duration-300 font-medium">
                        </div>
                    </div>
                </div>

                <div class="mb-12">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-blue-600 mb-6">Authorization Roles</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($roles as $role)
                        <label class="relative flex flex-col items-center p-4 bg-slate-50 rounded-2xl border-2 border-slate-50 cursor-pointer transition hover:bg-white hover:border-blue-100 group">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="hidden peer"
                                   {{ (isset($user) && $user->hasRole($role->name)) || (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}>
                            <div class="w-5 h-5 border-2 border-slate-200 rounded-lg flex items-center justify-center peer-checked:bg-blue-600 peer-checked:border-blue-600 transition mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-slate-600 peer-checked:text-blue-700 transition">{{ $role->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50 flex justify-end">
                    <button type="submit" class="bg-slate-900 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest shadow-2xl shadow-slate-900/20 hover:bg-slate-800 transition active:scale-95">
                        {{ isset($user) ? 'Save Updates' : 'Confirm Registration' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
