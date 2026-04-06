@extends('layouts.app')
@section('title', 'Note')
@section('content')

<div class="max-w-lg mx-auto">
    <a href="{{ route('admin.notes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux notes</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">📊 Détail de la note</h1>

    <div class="bg-white rounded shadow p-6 space-y-4">
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Apprenant</span>
            <p class="text-gray-800 font-medium">{{ $note->user->name }}</p>
            <p class="text-gray-400 text-sm">{{ $note->user->email }}</p>
        </div>
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Matière / Module</span>
            <p class="text-gray-800 font-medium">{{ $note->matiere }}</p>
        </div>
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Note</span>
            <p class="text-4xl font-bold
                @if($note->note >= 14) text-green-600
                @elseif($note->note >= 10) text-yellow-600
                @else text-red-600 @endif">
                {{ number_format($note->note, 2) }}<span class="text-xl text-gray-400">/20</span>
            </p>
        </div>
        <div>
            <span class="text-xs text-gray-500 uppercase font-semibold">Date</span>
            <p class="text-gray-700">{{ $note->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <div class="flex gap-4 mt-6">
        <a href="{{ route('admin.notes.edit', $note) }}"
           class="flex-1 bg-yellow-400 text-white px-6 py-2 rounded hover:bg-yellow-500 transition text-center font-semibold">
            ✏️ Modifier
        </a>
        <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" class="flex-1"
              onsubmit="return confirm('Supprimer cette note ?');">
            @csrf @method('DELETE')
            <button class="w-full bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition font-semibold">
                🗑️ Supprimer
            </button>
        </form>
    </div>
</div>

@endsection
