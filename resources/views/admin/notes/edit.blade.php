@extends('layouts.app')
@section('title', 'Modifier la note')
@section('content')

<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.notes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux notes</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">✏️ Modifier la note</h1>

    <form method="POST" action="{{ route('admin.notes.update', $note) }}" class="bg-white rounded shadow p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Apprenant *</label>
            <select name="user_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $note->user_id) == $user->id)>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Matière / Module *</label>
            <input type="text" name="matiere" value="{{ old('matiere', $note->matiere) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('matiere') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Note /20 *</label>
            <input type="number" name="note" value="{{ old('note', $note->note) }}" required
                   min="0" max="20" step="0.5"
                   class="w-40 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('note') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Mettre à jour
            </button>
            <a href="{{ route('admin.notes.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

@endsection
