<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Loft Manager') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=orbitron:400,700,900|figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
            .industrial-bg {
                background: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%);
            }
            .glass-panel {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .neon-yellow-text { color: #facc15; text-shadow: 0 0 10px rgba(250, 204, 21, 0.3); }
            .neon-yellow-border { border-color: #facc15; box-shadow: 0 0 10px rgba(250, 204, 21, 0.2); }
            .font-industrial { font-family: 'Orbitron', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased bg-black text-slate-300 industrial-bg overflow-hidden">
        <div class="flex h-screen w-full overflow-hidden" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-20 lg:w-64 bg-slate-950 border-r border-yellow-500/20 transform lg:translate-x-0 transition-transform duration-300"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                <livewire:layout.navigation />
            </aside>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-64 flex flex-col h-screen overflow-hidden">
                <!-- Top Header Bar -->
                <header class="h-16 flex items-center justify-between px-6 glass-panel border-b border-yellow-500/20 z-40">
                    <div class="flex items-center gap-4 lg:hidden">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-yellow-500 p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                        </button>
                    </div>
                    
                    <div class="hidden lg:block">
                        @if(isset($header))
                            <h2 class="font-industrial font-black text-xl text-white tracking-widest">
                                {{ $header }}
                            </h2>
                        @endif
                    </div>

                    <div class="flex items-center gap-6">
                        @if(Auth::user()->loft)
                            <!-- This block will now refresh automatically because it's part of the navigation component if moved there, 
                                 or we can keep it here and use a small Livewire component for the Resource Bar. 
                                 Let's create a dedicated ResourceBar component for the cleanest implementation. -->
                            <livewire:resource-bar />
                        @endif
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold uppercase tracking-tighter text-slate-500">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center font-black text-black text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Scrollable Viewport -->
                <main class="flex-1 overflow-y-auto custom-scrollbar p-6">
                    {{ $slot }}
                </main>
            </div>

            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"></div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #facc15; border-radius: 10px; }
        </style>
    </body>
</html>
