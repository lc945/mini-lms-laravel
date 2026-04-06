@extends('layouts.app')
@section('title', $formation->nom)
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux formations</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">📚 {{ $formation->nom }}</h1>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.formations.edit', $formation) }}"
           class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">✏️ Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="md:col-span-2 bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Description</h2>
        <p class="text-gray-600">{{ $formation->description ?: 'Aucune description.' }}</p>
    </div>
    <div class="bg-white rounded shadow p-6 space-y-3">
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Niveau</span>
            <p class="text-gray-800 font-medium">{{ $formation->niveau }}</p>
        </div>
        @if($formation->duree)
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Durée</span>
            <p class="text-gray-800 font-medium">⏱️ {{ $formation->duree }}h</p>
        </div>
        @endif
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Chapitres</span>
            <p class="text-gray-800 font-medium">{{ $formation->chapitres->count() }}</p>
        </div>
    </div>
</div>

<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold text-gray-800">📖 Chapitres</h2>
    <a href="{{ route('admin.chapitres.create') }}?formation_id={{ $formation->id }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">+ Ajouter un chapitre</a>
</div>

<div class="space-y-3">
    @forelse($formation->chapitres()->orderBy('ordre')->get() as $chapitre)
    <div class="bg-white rounded shadow p-4 flex justify-between items-center hover:shadow-md transition">
        <div>
            <h3 class="font-semibold text-gray-800">{{ $chapitre->ordre ? $chapitre->ordre.'. ' : '' }}{{ $chapitre->titre }}</h3>
            <p class="text-sm text-gray-500">{{ $chapitre->souschapitres->count() }} sous-chapitre(s)</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.chapitres.show', $chapitre) }}"
               class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition">👁️ Voir</a>
            <a href="{{ route('admin.chapitres.edit', $chapitre) }}"
               class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">✏️</a>
            <form method="POST" action="{{ route('admin.chapitres.destroy', $chapitre) }}" class="inline"
                  onsubmit="return confirm('Supprimer ce chapitre et tout son contenu ?');">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
            </form>
        </div>
    </div>
    @empty
        <div class="bg-gray-50 rounded p-6 text-center text-gray-500">
            Aucun chapitre. <a href="{{ route('admin.chapitres.create') }}?formation_id={{ $formation->id }}" class="text-blue-600 hover:underline">Créer le premier chapitre</a>
        </div>
    @endforelse
</div>

@endsection
