<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Loft | Premium Pigeon Simulation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=orbitron:400,700,900" rel="stylesheet" />
    <style>
        .font-industrial { font-family: 'Orbitron', sans-serif; }
        .industrial-bg {
            background: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%);
        }
        .hero-glow {
            text-shadow: 0 0 20px rgba(250, 204, 21, 0.4);
        }
    </style>
</head>
<body class="bg-black text-white industrial-bg min-h-screen">
    <nav class="p-8 flex justify-between items-center max-w-7xl mx-auto border-b border-white/5">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🕊️</span>
            <h1 class="font-industrial font-black text-2xl text-yellow-500 italic tracking-tighter uppercase">Elite Loft</h1>
        </div>
        <div class="flex items-center gap-8">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-industrial font-black text-sm text-black bg-yellow-500 px-8 py-3 rounded-2xl hover:bg-yellow-400 transition uppercase italic">Command Center</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-black text-slate-500 hover:text-white uppercase tracking-widest transition">Authentication</a>
                    <a href="{{ route('register') }}" class="font-industrial font-black text-sm text-black bg-white px-8 py-3 rounded-2xl hover:bg-yellow-500 transition uppercase italic">Join Sequence</a>
                @endauth
            @endif
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-8 pt-32 pb-20 text-center relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-yellow-500/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10">
            <span class="text-yellow-500 font-industrial font-black tracking-[0.4em] uppercase text-sm mb-6 block hero-glow">Generation V2 Protocol</span>
            <h2 class="text-7xl lg:text-9xl font-industrial font-black mb-10 leading-none italic uppercase tracking-tighter">
                Perfect <span class="text-yellow-500">Genetics.</span><br>Total <span class="outline-text text-transparent" style="-webkit-text-stroke: 2px white;">Dominance.</span>
            </h2>
            <p class="text-xl text-slate-500 mb-16 max-w-2xl mx-auto font-bold uppercase tracking-widest leading-relaxed">
                The world's most advanced pigeon management simulation. Engineer elite bloodlines, master the marketplace, and crush the rankings.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" 
                   class="font-industrial font-black text-lg text-black bg-yellow-500 px-12 py-6 rounded-[2rem] hover:scale-105 transition shadow-2xl shadow-yellow-500/20 uppercase italic tracking-widest">
                    Establish Your Loft
                </a>
            </div>
        </div>
    </main>

    <section class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-12 pb-32">
        <div class="bg-slate-950/50 border border-slate-800 p-10 rounded-[3rem]">
            <span class="text-yellow-500 text-3xl block mb-6">🧬</span>
            <h3 class="font-industrial font-black text-white text-xl uppercase mb-4 tracking-widest">Advanced Breeding</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider leading-relaxed">Multi-generational genetics engine with real-time incubation and inheritance tracking.</p>
        </div>
        <div class="bg-slate-950/50 border border-slate-800 p-10 rounded-[3rem]">
            <span class="text-yellow-500 text-3xl block mb-6">📊</span>
            <h3 class="font-industrial font-black text-white text-xl uppercase mb-4 tracking-widest">Global Terminal</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider leading-relaxed">Secure player-to-player asset exchange. Buy, sell, and trade elite units globally.</p>
        </div>
        <div class="bg-slate-950/50 border border-slate-800 p-10 rounded-[3rem]">
            <span class="text-yellow-500 text-3xl block mb-6">🏆</span>
            <h3 class="font-industrial font-black text-white text-xl uppercase mb-4 tracking-widest">Elite Rankings</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider leading-relaxed">Real-time competitive leaderboards. Prove your dominance across the entire network.</p>
        </div>
    </section>
</body>
</html>
