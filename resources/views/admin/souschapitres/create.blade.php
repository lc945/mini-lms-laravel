@extends('layouts.app')
@section('title', 'Nouveau Sous-chapitre')
@section('content')

<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.sous-chapitres.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux sous-chapitres</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">➕ Nouveau Sous-chapitre</h1>

    <form method="POST" action="{{ route('admin.sous-chapitres.store') }}" class="bg-white rounded shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Chapitre *</label>
            <select name="chapitre_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">Choisir un chapitre...</option>
                @foreach($chapitres as $c)
                    <option value="{{ $c->id }}" @selected(old('chapitre_id', request('chapitre_id')) == $c->id)>
                        {{ $c->formation->nom }} › {{ $c->titre }}
                    </option>
                @endforeach
            </select>
            @error('chapitre_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre *</label>
            <input type="text" name="titre" value="{{ old('titre') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Ex: Définition et importance">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Contenu pédagogique</label>
            <p class="text-xs text-gray-500 mb-2">Vous pouvez coller ici un texte généré par IA (ChatGPT, etc.)</p>
            <textarea name="contenu" rows="10"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 font-mono text-sm"
                      placeholder="Saisissez ou collez le contenu pédagogique ici...">{{ old('contenu') }}</textarea>
            @error('contenu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Lien de ressource externe</label>
            <input type="url" name="lien_ressource" value="{{ old('lien_ressource') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="https://exemple.com/ressource">
            @error('lien_ressource') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Ordre</label>
            <input type="number" name="ordre" value="{{ old('ordre', 1) }}" min="1"
                   class="w-32 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('ordre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Créer le sous-chapitre
            </button>
            <a href="{{ route('admin.sous-chapitres.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
