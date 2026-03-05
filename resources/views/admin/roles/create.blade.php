<x-admin-layout>
    @section('title', isset($role) ? 'Edit Role' : 'Create Role')

    <div class="max-w-4xl mx-auto">
        <div class="mb-8 font-sans">
            <a href="{{ route('admin.roles.index') }}" class="text-slate-400 hover:text-slate-600 flex items-center text-sm font-bold mb-4 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                Back to Roles
            </a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none">{{ isset($role) ? 'Configure Privilege' : 'Synthesize New Role' }}</h1>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
            <form action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}" method="POST" class="p-10 lg:p-14">
                @csrf
                @if(isset($role)) @method('PUT') @endif

                <div class="mb-14">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 mb-4">Role Designation</label>
                    <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" required placeholder="e.g. Finance Manager"
                           class="w-full text-3xl font-black text-slate-800 p-0 border-none focus:ring-0 placeholder-slate-200 bg-transparent">
                    <div class="h-1 w-24 bg-blue-600 mt-4 rounded-full"></div>
                    @error('name') <p class="text-red-500 text-xs mt-4 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="mb-14">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-blue-600">Permissions Matrix</h3>
                        <p class="text-xs text-slate-400 font-medium italic">Select capabilities for this role</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($permissions as $permission)
                        <label class="group relative flex items-center p-5 bg-slate-50 rounded-2xl border-2 border-slate-50 cursor-pointer transition-all duration-300 hover:bg-white hover:border-blue-100 hover:shadow-lg hover:shadow-blue-500/5">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="hidden peer"
                                   {{ (isset($role) && $role->hasPermissionTo($permission->name)) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                            
                            <div class="z-10 w-6 h-6 border-2 border-slate-200 rounded-lg flex items-center justify-center peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-all duration-300 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </div>
                            
                            <span class="z-10 text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-800 peer-checked:text-blue-700 transition-colors">{{ $permission->name }}</span>
                            
                            <!-- Active indicator -->
                            <div class="absolute inset-0 bg-blue-50 rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </label>
                        @endforeach
                    </div>
                    @if($permissions->isEmpty())
                    <div class="p-8 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                         <p class="text-slate-400 font-bold mb-4">No permissions registered yet.</p>
                         <a href="{{ route('admin.permissions.create') }}" class="text-blue-600 text-xs font-black uppercase tracking-widest">Create Permissions First</a>
                    </div>
                    @endif
                </div>

                <div class="flex justify-end items-center gap-6">
                    <a href="{{ route('admin.roles.index') }}" class="text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition">Discard</a>
                    <button type="submit" class="bg-slate-900 text-white px-16 py-6 rounded-3xl font-black uppercase tracking-widest shadow-2xl shadow-slate-900/30 hover:bg-slate-800 transition active:scale-95">
                        {{ isset($role) ? 'Update configuration' : 'Confirm synthesizer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
