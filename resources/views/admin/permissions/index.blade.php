<x-admin-layout>
    @section('title', 'Manage Permissions')

    <div class="flex justify-between items-center mb-12">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">Capabilities</h1>
            <p class="text-slate-400 text-sm font-bold tracking-widest mt-1 uppercase">Permission Matrix Definitions</p>
        </div>
        <div class="h-1 flex-1 mx-12 bg-slate-100 rounded-full hidden lg:block"></div>
        <a href="{{ route('admin.permissions.create') }}" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest flex items-center shadow-2xl shadow-slate-300 hover:bg-slate-800 transition active:scale-95">
            Register New
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-10 py-6 text-xs font-black uppercase tracking-[0.2em] text-slate-400">Permission Identifier</th>
                    <th class="px-10 py-6 text-xs font-black uppercase tracking-[0.2em] text-slate-400">System Namespace</th>
                    <th class="px-10 py-6 text-right text-xs font-black uppercase tracking-[0.2em] text-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($permissions as $permission)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-10 py-6">
                        <span class="text-lg font-black text-slate-700 tracking-tight">{{ $permission->name }}</span>
                    </td>
                    <td class="px-10 py-6">
                        <code class="text-[10px] font-mono bg-slate-100 px-2 py-1 rounded text-slate-500">spatie.permission.{{ $permission->name }}</code>
                    </td>
                    <td class="px-10 py-6 text-right">
                         <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-100 transition shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></a>
                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Delete?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-red-500 hover:border-red-100 transition shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                            </form>
                         </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
