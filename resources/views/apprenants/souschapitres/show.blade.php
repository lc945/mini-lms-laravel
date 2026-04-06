@extends('layouts.app')
@section('title', $sousChapitre->titre)
@section('content')

<!-- Fil d'Ariane -->
<div class="mb-4 text-sm text-gray-500">
    <a href="{{ route('apprenants.formations') }}" class="hover:text-blue-600">Mes formations</a>
    <span class="mx-2">›</span>
    <a href="{{ route('apprenants.formations.show', $formation) }}" class="hover:text-blue-600">{{ $formation->nom }}</a>
    <span class="mx-2">›</span>
    <span class="text-gray-700">{{ $sousChapitre->titre }}</span>
</div>

<!-- Titre -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        📄 {{ $sousChapitre->ordre ? $sousChapitre->ordre.'. ' : '' }}{{ $sousChapitre->titre }}
    </h1>
    <p class="text-sm text-blue-600 font-medium mt-1">{{ $chapitre->titre }}</p>
</div>

<!-- Contenu pédagogique -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    @if($sousChapitre->contenu)
        <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $sousChapitre->contenu }}</div>
    @else
        <p class="text-gray-400 italic">Aucun contenu disponible pour ce sous-chapitre.</p>
    @endif

    @if($sousChapitre->lien_ressource)
    <div class="mt-5 pt-5 border-t">
        <p class="text-sm font-semibold text-gray-600 mb-2">🔗 Ressource complémentaire</p>
        <a href="{{ $sousChapitre->lien_ressource }}" target="_blank"
           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline text-sm">
            {{ $sousChapitre->lien_ressource }}
            <span class="text-xs">(ouvre dans un nouvel onglet)</span>
        </a>
    </div>
    @endif
</div>

<!-- Quiz associé -->
@if($quiz)
<div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
    <div class="flex items-center gap-3 mb-3">
        <span class="text-3xl">📝</span>
        <div>
            <h2 class="text-lg font-bold text-purple-800">{{ $quiz->titre }}</h2>
            <p class="text-sm text-purple-600">{{ $quiz->questions->count() }} question(s)</p>
        </div>
    </div>
    <p class="text-gray-600 text-sm mb-4">Testez vos connaissances sur ce chapitre !</p>
    <a href="{{ route('quiz.passer', $quiz) }}"
       class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
        🚀 Passer le quiz
    </a>
</div>
@endif

<!-- Navigation -->
<div class="mt-6 flex justify-between">
    <a href="{{ route('apprenants.formations.show', $formation) }}"
       class="text-blue-600 hover:text-blue-800 font-medium">← Retour à la formation</a>
</div>

@endsection
