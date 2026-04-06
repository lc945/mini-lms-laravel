@extends('layouts.app')
@section('title', 'Chapitres')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📖 Chapitres</h1>
    <a href="{{ route('admin.chapitres.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Nouveau chapitre</a>
</div>

<div class="grid gap-4">
    @forelse($chapitres as $chapitre)
    <div class="bg-white rounded shadow p-5 flex justify-between items-start hover:shadow-lg transition">
        <div class="flex-1">
            <p class="text-xs text-blue-500 font-medium mb-1">{{ $chapitre->formation->nom }}</p>
            <h2 class="text-lg font-semibold text-gray-800">
                {{ $chapitre->ordre ? $chapitre->ordre.'. ' : '' }}{{ $chapitre->titre }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($chapitre->description, 100) }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $chapitre->souschapitres->count() }} sous-chapitre(s)</p>
        </div>
        <div class="flex gap-2 ml-4">
            <a href="{{ route('admin.chapitres.show', $chapitre) }}"
               class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition">👁️ Voir</a>
            <a href="{{ route('admin.chapitres.edit', $chapitre) }}"
               class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">✏️ Modifier</a>
            <form method="POST" action="{{ route('admin.chapitres.destroy', $chapitre) }}" class="inline"
                  onsubmit="return confirm('Supprimer ce chapitre ?');">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
            </form>
        </div>
    </div>
    @empty
        <p class="text-gray-500 text-center py-10 bg-white rounded shadow">
            Aucun chapitre. <a href="{{ route('admin.chapitres.create') }}" class="text-blue-600 hover:underline">Créer le premier</a>
        </p>
    @endforelse
</div>

@endsection
