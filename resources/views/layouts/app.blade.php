<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Loft Manager') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair+display:400,700,900|inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
            .loft-bg {
                background: radial-gradient(circle at center, #1a2a2a 0%, #0a1414 100%);
            }
            .parchment-panel {
                background: rgba(253, 251, 247, 0.05);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(184, 134, 11, 0.2);
            }
            .brass-text { color: #b8860b; text-shadow: 0 0 5px rgba(184, 134, 11, 0.2); }
            .brass-border { border-color: #b8860b; box-shadow: 0 0 15px rgba(184, 134, 11, 0.1); }
            .font-industrial { font-family: 'Playfair Display', serif; }
            .font-sans { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#0a1414] text-slate-300 loft-bg overflow-hidden">
        <div class="flex h-screen w-full overflow-hidden" x-data="{ 
                sidebarOpen: false, 
                toast: { show: false, message: '', type: 'success' } 
            }" 
            @notify.window="toast.message = $event.detail.message; toast.type = $event.detail.type; toast.show = true; setTimeout(() => toast.show = false, 5000)">
            
            <!-- Toast Notification -->
            <div x-show="toast.show" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="fixed top-20 right-4 z-[100] px-6 py-4 rounded-2xl shadow-2xl font-black font-industrial italic border-2 border-[#b8860b]/30 bg-[#1a2a2a] text-white"
                 :class="toast.type === 'success' ? 'border-green-500/50' : 'border-red-500/50'">
                <span x-text="toast.message"></span>
            </div>

            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#050a0a] border-r border-[#b8860b]/20 transform lg:translate-x-0 transition-transform duration-300 shadow-2xl"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                <livewire:layout.navigation />
            </aside>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-64 flex flex-col h-screen overflow-hidden">
                <!-- Top Header Bar -->
                <header class="h-16 flex items-center justify-between px-4 md:px-6 parchment-panel border-b border-[#b8860b]/20 z-40">
                    <div class="flex items-center gap-4 lg:hidden">
                        <span class="font-industrial font-black text-[#b8860b] tracking-tighter text-sm italic">LOFT LEDGER</span>
                    </div>
                    
                    <div class="hidden lg:block">
                        @if(isset($header))
                            <h2 class="font-industrial font-black text-xl text-white tracking-widest">
                                {{ $header }}
                            </h2>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 md:gap-6">
                        @if(Auth::user()->loft)
                            <livewire:resource-bar />
                        @endif
                        
                        <div class="flex items-center gap-2 md:gap-3">
                            <span class="hidden sm:block text-[10px] font-black uppercase tracking-tighter text-slate-500">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-[#b8860b] flex items-center justify-center font-black text-white text-xs shadow-lg shadow-[#b8860b]/20">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Scrollable Viewport -->
                <main class="flex-1 overflow-y-auto custom-scrollbar p-4 md:p-8 pb-24 lg:pb-8 bg-[#0a1414]">
                    {{ $slot }}
                </main>
            </div>

            <!-- Mobile Bottom Nav -->
            <div class="lg:hidden fixed bottom-0 left-0 right-0 h-20 bg-[#050a0a]/95 backdrop-blur-xl border-t border-[#b8860b]/20 flex items-center justify-around px-2 z-50">
                <x-v2-nav-link :href="route('dashboard')" icon="m19 11-7-7-7 7m14 0v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-8m14 0L12 5.41 5 11" :active="request()->routeIs('dashboard')" minimal>
                    Loft
                </x-v2-nav-link>
                <x-v2-nav-link :href="route('training.center')" icon="M13 10V3L4 14h7v7l9-11h-7z" :active="request()->routeIs('training.center')" minimal>
                    Train
                </x-v2-nav-link>
                <x-v2-nav-link :href="route('pigeons.index')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" :active="request()->routeIs('pigeons.index')" minimal>
                    Birds
                </x-v2-nav-link>
                <x-v2-nav-link :href="route('marketplace')" icon="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" :active="request()->routeIs('marketplace')" minimal>
                    Market
                </x-v2-nav-link>
                <button @click="sidebarOpen = true" class="flex flex-col items-center gap-1 px-2 py-2 text-slate-500 hover:text-[#b8860b] transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-tighter">Tools</span>
                </button>
            </div>

            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 lg:hidden"></div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #b8860b; border-radius: 10px; }
        </style>
    </body>
</html>
