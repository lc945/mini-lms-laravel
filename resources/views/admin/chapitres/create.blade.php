@extends('layouts.app')
@section('title', 'Nouveau Chapitre')
@section('content')

<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.chapitres.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux chapitres</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">➕ Nouveau Chapitre</h1>

    <form method="POST" action="{{ route('admin.chapitres.store') }}" class="bg-white rounded shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Formation *</label>
            <select name="formation_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">Choisir une formation...</option>
                @foreach($formations as $f)
                    <option value="{{ $f->id }}" @selected(old('formation_id', request('formation_id')) == $f->id)>
                        {{ $f->nom }}
                    </option>
                @endforeach
            </select>
            @error('formation_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre du chapitre *</label>
            <input type="text" name="titre" value="{{ old('titre') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Ex: Les verbes irréguliers">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Description du chapitre...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Ordre</label>
            <input type="number" name="ordre" value="{{ old('ordre', 1) }}" min="1"
                   class="w-32 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('ordre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Créer le chapitre
            </button>
            <a href="{{ route('admin.chapitres.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
