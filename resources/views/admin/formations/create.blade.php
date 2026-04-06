@extends('layouts.app')
@section('title', 'Nouvelle Formation')
@section('content')

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">➕ Nouvelle Formation</h1>

    <form method="POST" action="{{ route('admin.formations.store') }}" class="bg-white rounded shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom de la formation *</label>
            <input type="text" name="nom" value="{{ old('nom') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Ex: Anglais - Verbes Irréguliers">
            @error('nom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3" value="{{ old('description') }}"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Décrivez votre formation..."></textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Niveau *</label>
                <select name="niveau" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Choisir...</option>
                    <option value="Débutant">🟢 Débutant</option>
                    <option value="Intermédiaire">🟡 Intermédiaire</option>
                    <option value="Avancé">🔴 Avancé</option>
                </select>
                @error('niveau') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Durée (heures)</label>
                <input type="number" name="duree" value="{{ old('duree') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       placeholder="Ex: 10">
                @error('duree') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Créer la formation
            </button>
            <a href="{{ route('admin.formations.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
