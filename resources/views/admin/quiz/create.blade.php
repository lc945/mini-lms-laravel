@extends('layouts.app')
@section('title', 'Nouveau Quiz')
@section('content')

<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.quiz.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux quiz</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">➕ Nouveau Quiz</h1>

    <form method="POST" action="{{ route('admin.quiz.store') }}" class="bg-white rounded shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre du quiz *</label>
            <input type="text" name="titre" value="{{ old('titre') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Ex: Quiz — 10 verbes indispensables">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Sous-chapitre associé *</label>
            <select name="sous_chapitre_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">Choisir un sous-chapitre...</option>
                @foreach($souschapitres as $sc)
                    <option value="{{ $sc->id }}" @selected(old('sous_chapitre_id', request('sous_chapitre_id')) == $sc->id)>
                        {{ $sc->chapitre->formation->nom }} › {{ $sc->chapitre->titre }} › {{ $sc->titre }}
                        @if($sc->quiz) (⚠️ quiz existant) @endif
                    </option>
                @endforeach
            </select>
            @error('sous_chapitre_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Créer le quiz
            </button>
            <a href="{{ route('admin.quiz.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
