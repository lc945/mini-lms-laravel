@extends('layouts.app')
@section('title', $formation->nom)
@section('content')

<div class="mb-6">
    <a href="{{ route('apprenants.formations') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Mes formations</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">📚 {{ $formation->nom }}</h1>
    <div class="flex gap-3 mt-2 flex-wrap">
        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">{{ $formation->niveau }}</span>
        @if($formation->duree)
            <span class="bg-gray-100 text-gray-700 text-sm px-3 py-1 rounded-full">⏱️ {{ $formation->duree }}h</span>
        @endif
    </div>
    @if($formation->description)
        <p class="text-gray-600 mt-3">{{ $formation->description }}</p>
    @endif
</div>

@if($chapitres->isEmpty())
    <div class="bg-gray-50 rounded-lg p-8 text-center text-gray-500">
        Cette formation n'a pas encore de contenu.
    </div>
@else
    <div class="space-y-6">
        @foreach($chapitres as $chapitre)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white">
                    {{ $chapitre->ordre ? $chapitre->ordre.'. ' : '' }}{{ $chapitre->titre }}
                </h2>
                @if($chapitre->description)
                    <p class="text-blue-100 text-sm mt-1">{{ $chapitre->description }}</p>
                @endif
            </div>

            <div class="divide-y">
                @forelse($chapitre->souschapitres as $sc)
                <a href="{{ route('apprenants.souschapitres.show', $sc) }}"
                   class="flex justify-between items-center px-6 py-4 hover:bg-blue-50 transition group">
                    <div>
                        <p class="font-medium text-gray-800 group-hover:text-blue-700">
                            {{ $sc->ordre ? $sc->ordre.'. ' : '' }}{{ $sc->titre }}
                        </p>
                        @if($sc->quiz)
                            <span class="text-xs text-purple-600 font-medium">📝 Quiz disponible</span>
                        @endif
                    </div>
                    <span class="text-blue-400 group-hover:text-blue-600 text-xl">→</span>
                </a>
                @empty
                <div class="px-6 py-4 text-gray-400 text-sm italic">Aucun contenu dans ce chapitre.</div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
