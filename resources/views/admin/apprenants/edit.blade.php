@extends('layouts.app')
@section('title', 'Modifier apprenant')
@section('content')

<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.apprenants.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux apprenants</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">✏️ Modifier l'apprenant</h1>

    <form method="POST" action="{{ route('admin.apprenants.update', $apprenant) }}" class="bg-white rounded shadow p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom *</label>
            <input type="text" name="name" value="{{ old('name', $apprenant->name) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email *</label>
            <input type="email" name="email" value="{{ old('email', $apprenant->email) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Formation assignée</label>
            <select name="formation_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">— Aucune formation —</option>
                @foreach($formations as $f)
                    <option value="{{ $f->id }}" @selected(old('formation_id', $apprenant->formation_id) == $f->id)>
                        {{ $f->nom }} ({{ $f->niveau }})
                    </option>
                @endforeach
            </select>
            @error('formation_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Mettre à jour
            </button>
            <a href="{{ route('admin.apprenants.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
