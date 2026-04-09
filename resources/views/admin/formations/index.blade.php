@extends('layouts.app')
@section('title', 'Formations')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📚 Formations</h1>
    <div class="flex gap-3">
        <a href="{{ route('admin.ai.generate') }}"
           class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition font-semibold">
            🤖 Générer avec l'IA
        </a>
        <a href="{{ route('admin.formations.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Nouvelle formation
        </a>
    </div>
</div>

<div class="grid gap-4">
    @forelse($formations as $f)
    <div class="bg-white rounded shadow p-5 flex justify-between items-start hover:shadow-lg transition">
        <div class="flex-1">
            <h2 class="text-lg font-semibold text-gray-800">{{ $f->nom }}</h2>
            <p class="text-sm text-gray-500">
                Niveau : <span class="font-medium">{{ $f->niveau }}</span>
                @if($f->duree) · ⏱️ {{ $f->duree }}h @endif
            </p>
            <p class="text-gray-600 mt-1 text-sm">{{ Str::limit($f->description, 100) }}</p>
            <p class="text-xs text-blue-500 mt-2 font-medium">
                {{ $f->chapitres->count() }} chapitre(s)
            </p>
        </div>
        <div class="flex gap-2 ml-4">
            <a href="{{ route('admin.formations.edit', $f) }}" 
               class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">
                ✏️ Modifier
            </a>
            <form method="POST" action="{{ route('admin.formations.destroy', $f) }}" class="inline"
                  onsubmit="return confirm('Supprimer cette formation ?');">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                    🗑️ Supprimer
                </button>
            </form>
        </div>
    </div>
    @empty
        <p class="text-gray-500 text-center py-10 bg-white rounded shadow">
            Aucune formation. Créez-en une !
        </p>
    @endforelse
</div>

@endsection
