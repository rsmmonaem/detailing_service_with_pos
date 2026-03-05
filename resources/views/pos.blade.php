<x-app-layout>
    <div x-data="posForm({{ $services->toJson() }}, {{ $activeQr ? $activeQr->toJson() : 'null' }})" 
         class="max-w-md mx-auto min-h-screen bg-white shadow-lg flex flex-col relative overflow-hidden">
        
        <!-- Sidebar (Drawer) -->
        <div x-show="sidebarOpen" 
             x-cloak
             class="fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false">
        </div>
        
        <div x-show="sidebarOpen" 
             x-cloak
             class="fixed top-0 left-0 bottom-0 z-[101] w-72 bg-white shadow-2xl flex flex-col"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            
            <div class="p-6 bg-blue-600 text-white">
                <div class="flex items-center space-x-3 mb-4">
                    @if($settings['company_logo'])
                        <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo" class="h-12 w-12 rounded-2xl border-2 border-white/20 shadow-lg bg-white">
                    @else
                        <div class="h-12 w-12 rounded-2xl bg-white flex items-center justify-center border-2 border-white/20 shadow-lg">
                            <span class="text-blue-600 font-black text-xl">CW</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="font-bold text-lg leading-tight">{{ $settings['company_name'] }}</h2>
                        <p class="text-blue-100 text-xs mt-1">POS System v1.0</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto bg-slate-50">
                <p class="text-[10px] font-black uppercase text-slate-400 px-3 mb-2 tracking-widest">Navigation</p>
                
                <a href="{{ route('pos.index') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600 text-white shadow-md shadow-blue-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span class="font-bold">POS Terminal</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <span class="font-bold">Admin Panel</span>
                </a>

                <a href="{{ route('admin.sales.index') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-bold">Sales History</span>
                </a>

                <div class="pt-4 mt-4 border-t border-slate-200">
                    <p class="text-[10px] font-black uppercase text-slate-400 px-3 mb-2 tracking-widest">Configuration</p>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        <span class="font-bold">Manage Services</span>
                    </a>
                    <a href="{{ route('admin.qr_codes.index') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                        <span class="font-bold">QR Code Setup</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span class="font-bold">Store Settings</span>
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 font-medium">© 2026 DeepMind Labs</p>
            </div>
        </div>

        <!-- Header -->
        <header class="bg-blue-600 text-white p-4 sticky top-0 z-10 shadow-md no-print">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="p-1 hover:bg-blue-500 rounded-lg transition active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div class="flex items-center space-x-2">
                        @if($settings['company_logo'])
                            <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo" class="h-8 w-8 rounded-full border border-white">
                        @else
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center border border-white">
                                <span class="text-[10px] font-black">CW</span>
                            </div>
                        @endif
                        <h1 class="text-lg font-black tracking-tight truncate max-w-[150px]">{{ $settings['company_name'] }}</h1>
                    </div>
                </div>
                <button @click="resetForm()" class="bg-blue-500 hover:bg-blue-400 p-2.5 rounded-xl text-sm font-medium transition duration-200 shadow-lg active:rotate-180 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- POS Form Flow -->
        <div class="flex-1 overflow-y-auto p-4 space-y-6 no-print">
            <!-- Step Indicators -->
            <div class="flex justify-between items-center px-4">
                <template x-for="i in 3" :key="i">
                    <div class="flex items-center flex-1 last:flex-none">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow-sm transition-all duration-300"
                             :class="step >= i ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400'">
                            <span x-text="i"></span>
                        </div>
                        <div x-show="i < 3" class="h-1 flex-1 mx-2 rounded transition-all duration-500"
                             :class="step > i ? 'bg-blue-600' : 'bg-gray-200'"></div>
                    </div>
                </template>
            </div>

            <form @submit.prevent="submitForm" class="space-y-6" id="posForm">
                @csrf
                
                <!-- Step 1: Vehicle & Customer -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <span class="w-1 h-6 bg-blue-600 rounded-full mr-3"></span>
                        Vehicle Information
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">License Plate <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.license_plate" required placeholder="ABC 1234" 
                                   class="w-full p-4 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-0 text-xl font-bold uppercase transition duration-200 placeholder-slate-400 shadow-sm"
                                   autofocus @input="formData.license_plate = $event.target.value.toUpperCase()">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Mobile Number (Optional)</label>
                            <input type="tel" x-model="formData.customer_mobile" placeholder="0123456789" 
                                   class="w-full p-4 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-0 text-lg transition duration-200 placeholder-slate-400 shadow-sm">
                        </div>

                         <div x-show="showMoreFields" x-transition>
                             <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Customer Name (Optional)</label>
                                <input type="text" x-model="formData.customer_name" placeholder="John Doe" 
                                       class="w-full p-4 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-0 text-lg transition duration-200 placeholder-slate-400 shadow-sm">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Note (Optional)</label>
                                <textarea x-model="formData.note" placeholder="Any special instructions..." rows="2"
                                       class="w-full p-4 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-0 text-lg transition duration-200 placeholder-slate-400 shadow-sm"></textarea>
                            </div>
                         </div>

                         <button type="button" @click="showMoreFields = !showMoreFields" 
                                 class="w-full py-2 text-blue-600 font-medium text-sm flex items-center justify-center hover:bg-blue-50 rounded-lg transition">
                             <span x-text="showMoreFields ? 'Show Less' : 'Add Name & Note'"></span>
                             <svg x-show="!showMoreFields" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                 <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                             </svg>
                             <svg x-show="showMoreFields" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                 <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                             </svg>
                         </button>
                    </div>

                    <div class="pt-6">
                        <button type="button" @click="if(formData.license_plate) step = 2" :disabled="!formData.license_plate"
                                class="w-full py-5 bg-blue-600 text-white rounded-2xl font-bold text-xl shadow-lg active:scale-[0.98] transition-all disabled:opacity-50 disabled:active:scale-100 flex items-center justify-center">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Service & Amount -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <span class="w-1 h-6 bg-blue-600 rounded-full mr-3"></span>
                        Select Service
                    </h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <template x-for="service in services" :key="service.id">
                             <button type="button" @click="formData.service_type = service.name; formData.amount = service.default_amount"
                                     class="p-6 rounded-2xl border-2 flex flex-col items-center justify-center transition duration-200 shadow-sm group"
                                     :class="formData.service_type === service.name ? 'border-blue-600 bg-blue-50 ring-2 ring-blue-100 ring-offset-2' : 'border-slate-100 bg-white hover:border-blue-300'">
                                 <div class="w-12 h-12 mb-3 rounded-full flex items-center justify-center transition duration-200"
                                      :class="formData.service_type === service.name ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100'">
                                     <svg x-show="service.icon === 'Car Wash'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                     <svg x-show="service.icon === 'Polish'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                     <svg x-show="service.icon === 'Tinted'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                     <svg x-show="service.icon === 'Other' || !['Car Wash', 'Polish', 'Tinted'].includes(service.icon)" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                                 </div>
                                 <span class="font-bold text-sm" :class="formData.service_type === service.name ? 'text-blue-600' : 'text-slate-700'" x-text="service.name"></span>
                                 <span class="text-[10px] text-slate-400 mt-1" x-text="'{{ $settings['currency_symbol'] }} ' + Number(service.default_amount).toFixed(2)"></span>
                             </button>
                        </template>
                        
                        <div x-show="services.length === 0" class="col-span-2 p-10 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <p class="text-slate-400 font-medium">No active services. Please add services in the Admin Panel.</p>
                            <a href="/admin/services" class="text-blue-600 font-bold hover:underline mt-2 inline-block text-sm">Go to Admin</a>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Amount ({{ $settings['currency_symbol'] }}) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl font-bold text-slate-400">{{ $settings['currency_symbol'] }}</span>
                            <input type="number" x-model="formData.amount" required min="1" max="100000" placeholder="0.00" 
                                   class="w-full p-4 pl-14 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-0 text-3xl font-bold transition duration-200 p-8 shadow-sm">
                        </div>
                        
                        <!-- Quick Amount Options -->
                        <div class="grid grid-cols-4 gap-2 mt-4">
                            <template x-for="amt in [10, 20, 50, 100, 150, 200, 300, 500]" :key="amt">
                                <button type="button" @click="formData.amount = amt"
                                        class="py-2 px-1 border border-slate-200 rounded-lg text-sm font-bold bg-white active:bg-blue-600 active:text-white transition duration-200 shadow-sm"
                                        :class="formData.amount == amt ? 'bg-blue-600 text-white border-blue-600' : 'text-slate-600'">
                                    {{ $settings['currency_symbol'] }} <span x-text="amt"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-8">
                         <button type="button" @click="step = 1" 
                                class="py-5 bg-slate-100 text-slate-600 rounded-2xl font-bold text-xl active:scale-[0.98] transition">
                            Back
                        </button>
                        <button type="button" @click="if(formData.service_type && formData.amount) step = 3" :disabled="!formData.service_type || !formData.amount"
                                class="py-5 bg-blue-600 text-white rounded-2xl font-bold text-xl shadow-lg active:scale-[0.98] transition-all disabled:opacity-50 flex items-center justify-center">
                            Next
                        </button>
                    </div>
                </div>

                <!-- Step 3: Payment & Confirm -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <span class="w-1 h-6 bg-blue-600 rounded-full mr-3"></span>
                        Payment Method
                    </h2>
                    
                    <div class="space-y-4">
                        <template x-for="method in ['Cash', 'QR']" :key="method">
                             <button type="button" @click="formData.payment_method = method"
                                     class="w-full p-6 rounded-2xl border-2 flex items-center justify-between transition duration-200 shadow-sm overflow-hidden relative"
                                     :class="formData.payment_method === method ? 'border-blue-600 bg-blue-50 ring-2 ring-blue-100' : 'border-slate-100 bg-white'">
                                 <div class="flex items-center">
                                     <div class="w-12 h-12 mr-4 rounded-xl flex items-center justify-center text-white transition duration-200"
                                          :class="formData.payment_method === method ? (method === 'Cash' ? 'bg-green-600' : 'bg-purple-600') : 'bg-slate-200 text-slate-400'">
                                         <svg x-show="method === 'Cash'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                         <svg x-show="method === 'QR'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                     </div>
                                     <span class="font-bold text-lg" :class="formData.payment_method === method ? 'text-blue-700' : 'text-slate-700'" x-text="method"></span>
                                 </div>
                                 <div x-show="formData.payment_method === method" class="text-blue-600">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                         <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                     </svg>
                                 </div>
                             </button>
                        </template>
                    </div>

                    <!-- Order Summary Card -->
                    <div class="mt-8 p-6 bg-slate-900 text-white rounded-2xl shadow-xl overflow-hidden relative">
                         <div class="absolute -right-8 -bottom-8 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                         </div>
                         <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-4">Final Summary</h3>
                         <div class="flex justify-between items-start mb-4">
                             <div>
                                 <p class="text-3xl font-black uppercase tracking-tight" x-text="formData.license_plate"></p>
                                 <p class="text-slate-400 text-sm" x-text="formData.service_type"></p>
                             </div>
                             <div class="text-right">
                                 <p class="text-sm text-slate-400">Total</p>
                                 <p class="text-3xl font-black text-blue-400">{{ $settings['currency_symbol'] }} <span x-text="Number(formData.amount).toFixed(2)"></span></p>
                             </div>
                         </div>
                         <div class="pt-4 border-t border-slate-800 flex justify-between items-center">
                             <span class="text-slate-400 text-xs" x-text="formData.payment_method ? 'Pay via ' + formData.payment_method : 'Select Payment'"></span>
                             <span x-show="formData.customer_mobile" class="text-slate-400 text-xs" x-text="formData.customer_mobile"></span>
                         </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-8">
                         <button type="button" @click="step = 2" 
                                class="py-5 bg-slate-100 text-slate-600 rounded-2xl font-bold text-xl active:scale-[0.98] transition">
                            Back
                        </button>
                        <button type="button" @click="handleConfirm()" :disabled="!formData.payment_method || loading"
                                class="py-5 bg-blue-600 text-white rounded-2xl font-bold text-xl shadow-lg active:scale-[0.98] transition-all disabled:opacity-50 flex items-center justify-center relative">
                            <span x-show="!loading" x-text="formData.payment_method === 'QR' ? 'Show QR' : 'Confirm'"></span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- QR Payment Modal -->
        <div x-show="showQrModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-md"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden shadow-2xl"
                 x-transition:enter="transition ease-out duration-300 transform scale-95" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="p-8 text-center">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Scan to Pay</h3>
                    <p class="text-slate-500 text-sm mb-6" x-text="activeQr ? activeQr.name : 'Electronic Payment'"></p>
                    
                    <div class="aspect-square bg-slate-100 rounded-2xl flex items-center justify-center p-4 mb-8">
                        <template x-if="activeQr">
                            <img :src="'/storage/' + activeQr.image_path" alt="QR Code" class="max-w-full max-h-full object-contain shadow-sm">
                        </template>
                        <template x-if="!activeQr">
                            <div class="text-slate-400 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                <p class="text-xs">No active QR found in settings</p>
                            </div>
                        </template>
                    </div>

                    <button @click="showQrModal = false; submitForm()" class="w-full py-5 bg-blue-600 text-white rounded-2xl font-bold text-xl shadow-lg active:scale-95 transition">
                        I've Paid - Confirm
                    </button>
                    <button @click="showQrModal = false" class="w-full mt-3 py-3 text-slate-400 font-bold hover:text-slate-600 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Receipt Modal -->
        <div x-show="showReceipt" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden flex flex-col shadow-2xl relative"
                 x-transition:enter="transition ease-out duration-300 transform scale-95" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                
                <!-- Confetti/Success Header -->
                <div class="bg-green-600 p-6 text-white text-center relative overflow-hidden modal-header">
                    <div class="absolute -right-6 -top-6 rotate-12 opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h2 class="text-xl font-bold">Payment Successful!</h2>
                </div>

                <div class="p-6 overflow-y-auto max-h-[60vh] flex-1 bg-slate-50">
                    <!-- Thermal Receipt Paper -->
                    <div id="receipt-print" class="bg-white p-6 shadow-sm mx-auto w-full max-w-[280px] font-mono text-[11px] leading-tight text-black border-t-4 border-slate-200">
                        <div class="text-center mb-4">
                             @if($settings['company_logo'])
                                <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo" class="h-12 w-12 mx-auto mb-2 object-contain">
                            @endif
                            <h3 class="text-lg font-bold uppercase" x-text="receiptData.company_name"></h3>
                            <p class="whitespace-pre-line text-gray-700" x-text="receiptData.company_address"></p>
                            <div class="my-2 border-b border-dashed border-gray-400"></div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between"><span>Date:</span><span x-text="receiptData.date"></span></div>
                            <div class="flex justify-between"><span>Plate:</span><span class="font-bold underline" x-text="receiptData.license_plate"></span></div>
                             <div x-show="receiptData.customer_name" class="flex justify-between"><span>Name:</span><span x-text="receiptData.customer_name"></span></div>
                            <div x-show="receiptData.customer_mobile" class="flex justify-between"><span>Mobile:</span><span x-text="receiptData.customer_mobile"></span></div>
                        </div>

                        <div class="my-2 border-b border-dashed border-gray-400"></div>

                        <div class="space-y-2">
                            <div class="flex justify-between font-bold text-sm">
                                <span x-text="receiptData.service_type"></span>
                                <span><span x-text="receiptData.currency_symbol || 'RM'"></span> <span x-text="Number(receiptData.amount).toFixed(2)"></span></span>
                            </div>
                        </div>

                        <div class="my-2 border-b border-dashed border-gray-400"></div>

                        <div class="flex justify-between font-black text-base">
                            <span>TOTAL:</span>
                            <span><span x-text="receiptData.currency_symbol || 'RM'"></span> <span x-text="Number(receiptData.amount).toFixed(2)"></span></span>
                        </div>

                        <div class="mt-2 flex justify-between italic">
                            <span>Paid via:</span>
                            <span x-text="receiptData.payment_method"></span>
                        </div>

                        <div class="text-center mt-6">
                            <div class="my-2 border-b border-dashed border-gray-400"></div>
                            <p class="text-sm font-bold">THANK YOU!</p>
                            <p class="text-[9px] text-gray-500 mt-1">Please come again</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white border-t space-y-3">
                    <button @click="printReceipt()" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold flex items-center justify-center shadow-lg active:scale-95 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Print Receipt
                    </button>
                    <button @click="resetForm()" class="w-full py-3 bg-white border-2 border-slate-200 text-slate-600 rounded-2xl font-bold active:scale-95 transition">
                        New Sale
                    </button>
                    <a href="/admin/dashboard" class="block w-full text-center py-2 text-blue-600 text-xs font-semibold hover:underline">
                        Visit Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Hidden Print Frame (Legacy way for better printing control) -->
        <iframe id="print-iframe" class="hidden"></iframe>
    </div>

    @push('scripts')
    <script>
        function posForm(initialServices, initialQr) {
            return {
                step: 1,
                loading: false,
                sidebarOpen: false,
                showReceipt: false,
                showQrModal: false,
                showMoreFields: false,
                services: initialServices || [],
                activeQr: initialQr,
                formData: {
                    license_plate: '',
                    customer_mobile: '',
                    customer_name: '',
                    note: '',
                    service_type: '',
                    amount: '',
                    payment_method: ''
                },
                receiptData: {},
                
                resetForm() {
                    this.formData = {
                        license_plate: '',
                        customer_mobile: '',
                        customer_name: '',
                        note: '',
                        service_type: '',
                        amount: '',
                        payment_method: ''
                    };
                    this.step = 1;
                    this.showReceipt = false;
                    this.showQrModal = false;
                    this.loading = false;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                handleConfirm() {
                    if (this.formData.payment_method === 'QR') {
                        this.showQrModal = true;
                    } else {
                        this.submitForm();
                    }
                },

                async submitForm() {
                    this.loading = true;
                    try {
                        const response = await fetch('/pos', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.receiptData = result.receipt;
                            this.receiptData.customer_name = this.formData.customer_name; // Since it might not be in DB return
                            this.showReceipt = true;
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Submit error:', error);
                        alert('Something went wrong. Please check your connection.');
                    } finally {
                        this.loading = false;
                    }
                },

                printReceipt() {
                    window.print();
                }
            }
        }
    </script>
    @endpush

    <style>
        /* Custom scrollbar for mobile feel */
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }

        @media print {
            .no-print, header, footer, aside, nav, button, .modal-header {
                display: none !important;
            }
            body, main {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            #receipt-print {
                border: none !important;
                box-shadow: none !important;
                width: 100% !important;
                max-width: 57mm !important;
                margin: 0 auto !important;
                padding: 0 !important;
                font-family: monospace !important;
                font-size: 10px !important;
                display: block !important;
            }
            #receipt-print h3 { font-size: 14px !important; }
            #receipt-print .bg-blue-50 { background: transparent !important; color: black !important; border-top: 1px dashed black !important; border-bottom: 1px dashed black !important; margin: 10px 0 !important; padding: 10px 0 !important; }
            #receipt-print .text-slate-500, #receipt-print .text-slate-400 { color: black !important; }

            /* Modal overrides to show content only */
            .fixed.inset-0 { position: static !important; display: block !important; background: transparent !important; padding: 0 !important; backdrop-filter: none !important; }
            .bg-white.rounded-3xl.w-full.max-w-sm { max-width: 100% !important; box-shadow: none !important; border-radius: 0 !important; background: transparent !important; }
            .p-6.overflow-y-auto { background: transparent !important; padding: 0 !important; max-height: none !important; overflow: visible !important; }
        }
    </style>
</x-app-layout>
