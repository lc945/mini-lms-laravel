@extends('layouts.app')
@section('title', 'Mes Formations')
@section('content')

<h1 class="text-3xl font-bold mb-8">📚 Mes Formations</h1>

@if($formations->count() == 0)
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
        <p class="text-gray-600 text-lg">Aucune formation disponible pour le moment.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($formations as $formation)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:scale-105">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32 flex items-center justify-center">
                <span class="text-white text-5xl">📚</span>
            </div>

            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $formation->nom }}</h3>

                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($formation->description, 80) }}</p>

                <div class="flex gap-2 mb-4 flex-wrap">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                        {{ ucfirst($formation->niveau) }}
                    </span>
                    @if($formation->duree)
                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full font-medium">
                        ⏱️ {{ $formation->duree }}h
                    </span>
                    @endif
                </div>

                <div class="mb-4 text-sm text-gray-600 font-medium">
                    📖 <strong>{{ $formation->chapitres->count() }}</strong> chapitre(s)
                </div>

                <a href="{{ route('apprenants.formations.show', $formation) }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                    👉 Suivre la formation
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
