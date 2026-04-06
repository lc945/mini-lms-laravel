@extends('layouts.app')
@section('title', 'Modifier Quiz')
@section('content')

<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.quiz.show', $quiz) }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour au quiz</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">✏️ Modifier le Quiz</h1>

    <form method="POST" action="{{ route('admin.quiz.update', $quiz) }}" class="bg-white rounded shadow p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre du quiz *</label>
            <input type="text" name="titre" value="{{ old('titre', $quiz->titre) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Sous-chapitre associé *</label>
            <select name="sous_chapitre_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                @foreach($souschapitres as $sc)
                    <option value="{{ $sc->id }}" @selected(old('sous_chapitre_id', $quiz->sous_chapitre_id) == $sc->id)>
                        {{ $sc->chapitre->formation->nom }} › {{ $sc->chapitre->titre }} › {{ $sc->titre }}
                    </option>
                @endforeach
            </select>
            @error('sous_chapitre_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Mettre à jour
            </button>
            <a href="{{ route('admin.quiz.show', $quiz) }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
