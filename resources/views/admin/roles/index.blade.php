<x-admin-layout>
    @section('title', 'System Roles')

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Access Control Roles</h1>
            <p class="text-slate-500 text-sm font-medium">Define permission groups for your staff</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold flex items-center shadow-lg shadow-blue-200 hover:bg-blue-700 transition active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Define New Role
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
            <div>
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black">
                         {{ strtoupper(substr($role->name, 0, 1)) }}
                    </div>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                         <a href="{{ route('admin.roles.edit', $role) }}" class="p-2 text-slate-400 hover:text-blue-600 transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></a>
                         <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Delete role?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="p-2 text-slate-400 hover:text-red-500 transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                         </form>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight mb-2">{{ $role->name }}</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-6">Permissions granted: {{ $role->permissions->count() }}</p>
                
                <div class="flex flex-wrap gap-2 mb-8">
                     @forelse($role->permissions->take(5) as $permission)
                     <span class="px-2 py-1 bg-slate-50 text-slate-500 text-[9px] font-black uppercase rounded-md border border-slate-100">{{ $permission->name }}</span>
                     @empty
                     <span class="text-slate-300 text-[10px] italic">Universal access</span>
                     @endforelse
                     @if($role->permissions->count() > 5)
                     <span class="text-[9px] font-black text-blue-600 px-2 py-1">+{{ $role->permissions->count() - 5 }} More</span>
                     @endif
                </div>
            </div>
            
            <a href="{{ route('admin.roles.edit', $role) }}" class="w-full py-3 bg-slate-50 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest text-center hover:bg-slate-900 hover:text-white transition duration-300">
                Manage Permissions
            </a>
        </div>
        @endforeach
    </div>
</x-admin-layout>
