<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini LMS — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navigation -->
<nav class="bg-blue-700 text-white px-6 py-3 shadow-lg">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="/" class="font-bold text-xl flex items-center gap-2">
            🎓 Mini LMS
        </a>
        <div class="flex gap-3 items-center flex-wrap">
            @auth
                <span class="text-sm opacity-75 hidden md:inline">{{ auth()->user()->name }}</span>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:underline text-sm">🏠 Dashboard</a>
                    <a href="{{ route('admin.ai.generate') }}" class="bg-purple-500 hover:bg-purple-600 px-3 py-1 rounded-lg text-sm font-semibold transition">🤖 IA</a>
                    <a href="{{ route('admin.formations.index') }}" class="hover:underline text-sm">📚 Formations</a>
                    <a href="{{ route('admin.apprenants.index') }}" class="hover:underline text-sm">👥 Apprenants</a>
                    <a href="{{ route('admin.notes.index') }}" class="hover:underline text-sm">📊 Notes</a>
                @else
                    <a href="{{ route('apprenants.dashboard') }}" class="hover:underline text-sm">🏠 Dashboard</a>
                    <a href="{{ route('apprenants.formations') }}" class="hover:underline text-sm">📚 Mes formations</a>
                    <a href="{{ route('notes.mes-notes') }}" class="hover:underline text-sm">📊 Mes notes</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 transition text-sm">Déconnexion</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="max-w-7xl mx-auto mt-6 px-4 pb-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
            ❌ {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>
