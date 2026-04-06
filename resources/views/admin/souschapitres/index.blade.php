@extends('layouts.app')
@section('title', 'Sous-chapitres')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📄 Sous-chapitres</h1>
    <a href="{{ route('admin.sous-chapitres.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Nouveau sous-chapitre</a>
</div>

<div class="grid gap-4">
    @forelse($souschapitres as $sc)
    <div class="bg-white rounded shadow p-5 flex justify-between items-start hover:shadow-lg transition">
        <div class="flex-1">
            <p class="text-xs text-blue-500 font-medium mb-1">{{ $sc->chapitre->formation->nom }} › {{ $sc->chapitre->titre }}</p>
            <h2 class="text-lg font-semibold text-gray-800">
                {{ $sc->ordre ? $sc->ordre.'. ' : '' }}{{ $sc->titre }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($sc->contenu, 120) }}</p>
            @if($sc->quiz)
                <span class="inline-block mt-2 bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full">📝 Quiz associé</span>
            @endif
        </div>
        <div class="flex gap-2 ml-4">
            <a href="{{ route('admin.sous-chapitres.show', $sc) }}"
               class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition">👁️ Voir</a>
            <a href="{{ route('admin.sous-chapitres.edit', $sc) }}"
               class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">✏️</a>
            <form method="POST" action="{{ route('admin.sous-chapitres.destroy', $sc) }}" class="inline"
                  onsubmit="return confirm('Supprimer ce sous-chapitre ?');">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
            </form>
        </div>
    </div>
    @empty
        <p class="text-gray-500 text-center py-10 bg-white rounded shadow">
            Aucun sous-chapitre.
        </p>
    @endforelse
</div>

@endsection
