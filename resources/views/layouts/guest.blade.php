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
            .industrial-bg {
                background: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%);
                position: relative;
                overflow: hidden;
            }
            .industrial-bg::before {
                content: "";
                position: absolute;
                inset: 0;
                background-image: linear-gradient(rgba(250, 204, 21, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(250, 204, 21, 0.05) 1px, transparent 1px);
                background-size: 50px 50px;
                z-index: 0;
            }
            .font-industrial { font-family: 'Orbitron', sans-serif; }
            .glow-card {
                background: rgba(15, 23, 42, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(250, 204, 21, 0.2);
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(250, 204, 21, 0.05);
            }
        </style>
    </head>
    <body class="font-sans text-slate-200 antialiased industrial-bg min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="relative z-10">
            <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
                <a href="/" wire:navigate class="inline-block mb-6">
                    <span class="text-6xl">🕊️</span>
                    <h1 class="mt-4 font-industrial font-black text-3xl text-yellow-500 tracking-tighter italic uppercase">Elite Loft</h1>
                </a>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="glow-card py-8 px-4 shadow-2xl sm:rounded-3xl sm:px-10 border-t-4 border-t-yellow-500">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
