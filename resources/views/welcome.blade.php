<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pigeon Racer | Manage Your Loft, Win the Skies</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white font-sans">
    <nav class="p-6 flex justify-between items-center max-w-6xl mx-auto">
        <h1 class="text-3xl font-black text-indigo-400">Pigeon Racer</h1>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-indigo-600 rounded-full font-bold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mr-4 text-gray-300 hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-indigo-600 rounded-full font-bold hover:bg-indigo-500 transition">Get Started</a>
                @endauth
            @endif
        </div>
    </nav>

    <header class="text-center py-20 px-6">
        <h2 class="text-6xl font-black mb-6 leading-tight">Train Champions.<br><span class="text-indigo-400">Own the Skies.</span></h2>
        <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">Build the ultimate pigeon racing loft, train your birds, and compete for glory in this competitive simulation game.</p>
        <a href="{{ route('register') }}" class="px-10 py-4 bg-indigo-600 text-xl rounded-full font-bold hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/20">Start Your Loft Today</a>
    </header>
</body>
</html>
