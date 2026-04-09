@extends('layouts.app')
@section('title', 'Mon espace')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">👋 Bonjour, {{ auth()->user()->name }}</h1>
    <p class="text-gray-500 mt-1">Bienvenue dans votre espace d'apprentissage.</p>
</div>

@if($dernierSousChapitre)
<!-- Reprendre -->
<div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <span class="text-3xl">▶️</span>
        <div>
            <p class="font-bold text-blue-800">Commencer l'apprentissage</p>
            <p class="text-sm text-blue-600">{{ $dernierSousChapitre->titre }}</p>
        </div>
    </div>
    <a href="{{ route('apprenants.souschapitres.show', $dernierSousChapitre) }}"
       class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
        Démarrer →
    </a>
</div>
@endif

<!-- Formations disponibles -->
<div class="mb-6">
    <h2 class="text-lg font-bold text-gray-700 mb-3">📚 Formations disponibles</h2>
    @forelse($formations as $formation)
    <div class="bg-white rounded-xl shadow p-5 mb-3 flex justify-between items-center hover:shadow-md transition">
        <div>
            <p class="font-bold text-gray-800">{{ $formation->nom }}</p>
            <p class="text-sm text-gray-500 mt-0.5">
                Niveau : <span class="font-medium">{{ $formation->niveau }}</span>
                · {{ $formation->chapitres_count }} chapitre(s)
                @if($formation->duree) · ⏱ {{ $formation->duree }}h @endif
            </p>
        </div>
        <a href="{{ route('apprenants.formations.show', $formation) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-semibold whitespace-nowrap ml-4">
            Accéder →
        </a>
    </div>
    @empty
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
        <p class="text-yellow-800 font-semibold">Aucune formation disponible pour le moment.</p>
        <p class="text-yellow-600 text-sm mt-1">Revenez bientôt !</p>
    </div>
    @endforelse
</div>

<!-- Mes notes -->
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-700">📊 Mes dernières notes</h2>
        <a href="{{ route('notes.mes-notes') }}" class="text-blue-600 hover:underline text-sm">Voir tout →</a>
    </div>
    @if($moyenneNotes)
    <div class="mb-4 p-3 rounded-lg text-center
        @if($moyenneNotes >= 14) bg-green-50 border border-green-200
        @elseif($moyenneNotes >= 10) bg-orange-50 border border-orange-200
        @else bg-red-50 border border-red-200 @endif">
        <p class="text-sm text-gray-500">Moyenne générale</p>
        <p class="text-3xl font-bold
            @if($moyenneNotes >= 14) text-green-600
            @elseif($moyenneNotes >= 10) text-orange-500
            @else text-red-500 @endif">
            {{ number_format($moyenneNotes, 1) }}/20
        </p>
    </div>
    @endif
    @forelse($notes as $note)
    <div class="flex justify-between items-center py-3 border-b last:border-0">
        <p class="font-semibold text-gray-800 text-sm">{{ $note->matiere }}</p>
        <span class="font-bold
            @if($note->note >= 14) text-green-600
            @elseif($note->note >= 10) text-orange-500
            @else text-red-500 @endif">
            {{ $note->note }}/20
        </span>
    </div>
    @empty
    <p class="text-gray-400 text-sm italic">Aucune note pour le moment.</p>
    @endforelse
</div>

@endsection
