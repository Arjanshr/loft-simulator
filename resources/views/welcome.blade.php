<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loft Manager | The Aviary & Tactical Ledger</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:400,700,900|inter:400,500,600,700,800|jetbrains+mono:400,700&display=swap" rel="stylesheet" />
    <style>
        .font-industrial { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        .loft-wood {
            background-color: #1a1410;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 40px, rgba(45, 36, 30, 0.2) 40px, rgba(45, 36, 30, 0.2) 80px);
        }
        .hero-glow {
            text-shadow: 0 0 20px rgba(184, 134, 11, 0.4);
        }
        .parchment-panel {
            background: rgba(253, 251, 247, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(184, 134, 11, 0.2);
            box-shadow: inset 0 0 40px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-[#1a1410] text-slate-300 loft-wood min-h-screen font-sans">
    <nav class="p-8 flex justify-between items-center max-w-7xl mx-auto border-b border-white/5">
        <div class="flex items-center gap-4">
            <span class="text-3xl">🕊️</span>
            <h1 class="font-industrial font-black text-2xl text-[#b8860b] italic tracking-tighter uppercase">Loft Manager</h1>
        </div>
        <div class="flex items-center gap-8">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-industrial font-black text-sm text-white bg-[#b8860b] px-8 py-3 rounded-2xl hover:bg-[#3b82f6] transition uppercase italic shadow-lg border border-white/10">Enter Registry</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-black text-slate-500 hover:text-white uppercase tracking-widest transition italic">Authentication</a>
                    <a href="{{ route('register') }}" class="font-industrial font-black text-sm text-white bg-transparent border-2 border-[#b8860b] px-8 py-3 rounded-2xl hover:bg-[#b8860b] transition uppercase italic shadow-xl">Join Registry</a>
                @endauth
            @endif
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-8 pt-32 pb-20 text-center relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[#b8860b]/5 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="relative z-10">
            <span class="text-[#b8860b] font-industrial font-black tracking-[0.4em] uppercase text-sm mb-6 block hero-glow italic">Established MMXXVI</span>
            <h2 class="text-6xl lg:text-9xl font-industrial font-black mb-10 leading-none italic uppercase tracking-tighter text-white">
                Superior <span class="text-[#b8860b]">Strains.</span><br><span class="outline-text text-transparent" style="-webkit-text-stroke: 1px rgba(255,255,255,0.3);">Hereditary</span> Precision.
            </h2>
            <p class="text-lg md:text-xl text-slate-500 mb-16 max-w-2xl mx-auto font-medium uppercase tracking-[0.2em] leading-relaxed italic">
                Master the art of professional pigeon management. Cultivate champion bloodlines, analyze performance logs, and dominate the global exchange.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" 
                   class="font-industrial font-black text-lg text-white bg-[#b8860b] px-12 py-6 rounded-[2rem] hover:scale-105 hover:bg-[#3b82f6] transition shadow-2xl shadow-[#b8860b]/20 uppercase italic tracking-widest border border-white/10">
                    Register Your Loft
                </a>
            </div>
        </div>
    </main>

    <section class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-12 pb-40">
        <div class="parchment-panel p-12 rounded-[3rem] hover:border-[#3b82f6]/30 transition-all shadow-2xl group border-2 border-white/5">
            <span class="text-[#b8860b] text-4xl block mb-8 group-hover:scale-110 transition-transform">🥚</span>
            <h3 class="font-industrial font-black text-white text-2xl uppercase mb-4 tracking-widest italic">Selective Breeding</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest leading-relaxed italic">Detailed nesting registries with deep hereditary trait inheritance and performance tracking.</p>
        </div>
        <div class="parchment-panel p-12 rounded-[3rem] hover:border-[#3b82f6]/30 transition-all shadow-2xl group border-2 border-white/5">
            <span class="text-[#3b82f6] text-4xl block mb-8 group-hover:scale-110 transition-transform">📜</span>
            <h3 class="font-industrial font-black text-white text-2xl uppercase mb-4 tracking-widest italic">Tactical Exchange</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest leading-relaxed italic">The global pigeon registry. Acquire elite specimens and trade for superior genetic potential.</p>
        </div>
        <div class="parchment-panel p-12 rounded-[3rem] hover:border-[#3b82f6]/30 transition-all shadow-2xl group border-2 border-white/5">
            <span class="text-[#b8860b] text-4xl block mb-8 group-hover:scale-110 transition-transform">🏆</span>
            <h3 class="font-industrial font-black text-white text-2xl uppercase mb-4 tracking-widest italic">Loft Rankings</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest leading-relaxed italic">Global prestige rankings. Prove your mastery as a breeder against the world's finest lofts.</p>
        </div>
    </section>
</body>
</html>
