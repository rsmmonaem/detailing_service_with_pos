<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'POS System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-between h-20 px-6 bg-slate-950">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                           <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" /><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">WashPOS</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" /></svg>
                </button>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
                @can('view_sales')
                <a href="{{ route('admin.sales.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.sales.index') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    Sales History
                </a>
                @endcan
                @can('manage_services')
                <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.services.index*') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Manage Services
                </a>
                @endcan
                @can('manage_settings')
                <a href="{{ route('admin.qr_codes.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.qr_codes.index*') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    QR Codes
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.settings.index') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    Settings
                </a>
                @endcan

                @if(auth()->user()->can('manage_users') || auth()->user()->can('manage_roles') || auth()->user()->can('manage_permissions'))
                <div class="pt-6 mt-6 border-t border-slate-800">
                    <p class="text-[10px] font-black uppercase text-slate-500 px-4 mb-2 tracking-[0.2em]">Access Control</p>
                    @can('manage_users')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" /></svg>
                        Admin Users
                    </a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 21a11.955 11.955 0 01-9.618-7.016m19.236 0a11.952 11.952 0 00-3.059-12.459L12 3m0 0L3.823 8.541a11.952 11.952 0 00-3.059 12.459" /></svg>
                        System Roles
                    </a>
                    @endcan
                    @can('manage_permissions')
                    <a href="{{ route('admin.permissions.index') }}" class="flex items-center px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-600/10 text-blue-500 font-semibold' : 'hover:bg-slate-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                        Permissions
                    </a>
                    @endcan
                </div>
                @endif
                <div class="pt-6 mt-6 border-t border-slate-800">
                    <a href="{{ route('pos.index') }}" class="flex items-center px-4 py-3 rounded-xl text-blue-400 hover:bg-blue-500/10 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Launch POS
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-10">
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <h2 class="text-xl font-bold text-slate-800 truncate">@yield('title', 'Admin Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-slate-600 p-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </button>
                    </form>
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold overflow-hidden border-2 border-slate-100">
                         <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" alt="Avatar">
                    </div>
                </div>
            </header>

            <main class="p-6 lg:p-10 flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
