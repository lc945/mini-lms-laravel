@extends('layouts.app')
@section('title', $chapitre->titre)
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.formations.show', $chapitre->formation) }}" class="text-blue-600 hover:text-blue-800 text-sm">
            ← {{ $chapitre->formation->nom }}
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">
            📖 {{ $chapitre->ordre ? $chapitre->ordre.'. ' : '' }}{{ $chapitre->titre }}
        </h1>
        @if($chapitre->description)
            <p class="text-gray-500 mt-1">{{ $chapitre->description }}</p>
        @endif
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.chapitres.edit', $chapitre) }}"
           class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">✏️ Modifier</a>
    </div>
</div>

<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold text-gray-800">📄 Sous-chapitres</h2>
    <a href="{{ route('admin.sous-chapitres.create') }}?chapitre_id={{ $chapitre->id }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">+ Ajouter un sous-chapitre</a>
</div>

<div class="space-y-3">
    @forelse($chapitre->souschapitres()->orderBy('ordre')->get() as $sc)
    <div class="bg-white rounded shadow p-4 flex justify-between items-center hover:shadow-md transition">
        <div class="flex-1">
            <h3 class="font-semibold text-gray-800">{{ $sc->ordre ? $sc->ordre.'. ' : '' }}{{ $sc->titre }}</h3>
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
        <div class="bg-gray-50 rounded p-6 text-center text-gray-500">
            Aucun sous-chapitre.
            <a href="{{ route('admin.sous-chapitres.create') }}?chapitre_id={{ $chapitre->id }}" class="text-blue-600 hover:underline">Créer le premier</a>
        </div>
    @endforelse
</div>

@endsection
