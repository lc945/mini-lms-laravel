@extends('layouts.app')
@section('title', 'Modifier Chapitre')
@section('content')

<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour au chapitre</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">✏️ Modifier le Chapitre</h1>

    <form method="POST" action="{{ route('admin.chapitres.update', $chapitre) }}" class="bg-white rounded shadow p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Formation *</label>
            <select name="formation_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                @foreach($formations as $f)
                    <option value="{{ $f->id }}" @selected(old('formation_id', $chapitre->formation_id) == $f->id)>
                        {{ $f->nom }}
                    </option>
                @endforeach
            </select>
            @error('formation_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre du chapitre *</label>
            <input type="text" name="titre" value="{{ old('titre', $chapitre->titre) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('description', $chapitre->description) }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Ordre</label>
            <input type="number" name="ordre" value="{{ old('ordre', $chapitre->ordre) }}" min="1"
                   class="w-32 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('ordre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Mettre à jour
            </button>
            <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
