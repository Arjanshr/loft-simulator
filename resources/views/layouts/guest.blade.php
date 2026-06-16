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
            .loft-bg {
                background: radial-gradient(circle at center, #1a2a2a 0%, #0a1414 100%);
                position: relative;
                overflow: hidden;
            }
            .loft-bg::before {
                content: "";
                position: absolute;
                inset: 0;
                background-image: linear-gradient(rgba(184, 134, 11, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(184, 134, 11, 0.03) 1px, transparent 1px);
                background-size: 60px 60px;
                z-index: 0;
            }
            .font-industrial { font-family: 'Playfair Display', serif; }
            .font-sans { font-family: 'Inter', sans-serif; }
            .parchment-card {
                background: rgba(10, 20, 20, 0.9);
                backdrop-filter: blur(15px);
                border: 1px solid rgba(184, 134, 11, 0.2);
                box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
            }
        </style>
    </head>
    <body class="font-sans text-slate-300 antialiased loft-bg min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="relative z-10">
            <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
                <a href="/" wire:navigate class="inline-block mb-6 group">
                    <div class="w-20 h-20 bg-[#b8860b] rounded-[2rem] flex items-center justify-center shadow-2xl shadow-[#b8860b]/20 mx-auto rotate-3 group-hover:rotate-0 transition-transform duration-500 mb-4">
                        <span class="text-4xl">🕊️</span>
                    </div>
                    <h1 class="font-industrial font-black text-3xl text-[#b8860b] tracking-tighter italic uppercase">Elite Loft</h1>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.5em] mt-2">Established 2026</p>
                </a>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="parchment-card py-10 px-8 shadow-2xl sm:rounded-[3rem] sm:px-12 border-t-8 border-t-[#b8860b]/80 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#b8860b]/5 blur-[80px] rounded-full"></div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
