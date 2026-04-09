@extends('layouts.app')
@section('title', $sousChapitre->titre)
@section('content')

<div class="flex gap-6">
    <!-- Sidebar arborescence -->
    <div class="hidden md:block w-64 flex-shrink-0">
        <div class="bg-white rounded-xl shadow p-4 sticky top-4">
            <p class="text-xs font-bold text-gray-400 uppercase mb-3">Plan du cours</p>
            <p class="font-bold text-blue-700 text-sm mb-3">{{ $formation->nom }}</p>
            @foreach($formation->chapitres()->orderBy('ordre')->with(['souschapitres' => fn($q) => $q->orderBy('ordre')])->get() as $ch)
            <div class="mb-3">
                <p class="text-xs font-bold text-gray-500 uppercase mb-1">{{ $ch->titre }}</p>
                @foreach($ch->souschapitres as $sc)
                <a href="{{ route('apprenants.souschapitres.show', $sc) }}"
                   class="flex items-center gap-2 text-sm py-1.5 px-2 rounded-lg mb-0.5 transition
                       {{ $sc->id === $sousChapitre->id
                           ? 'bg-blue-600 text-white font-semibold'
                           : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="{{ $sc->id === $sousChapitre->id ? 'text-white' : 'text-gray-400' }}">
                        {{ $sc->id === $sousChapitre->id ? '▶' : '○' }}
                    </span>
                    <span class="leading-tight">{{ $sc->titre }}</span>
                </a>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 min-w-0">
        <!-- Fil d'Ariane -->
        <div class="mb-4 text-sm text-gray-500">
            <a href="{{ route('apprenants.formations') }}" class="hover:text-blue-600">Mes formations</a>
            <span class="mx-2">›</span>
            <a href="{{ route('apprenants.formations.show', $formation) }}" class="hover:text-blue-600">{{ $formation->nom }}</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">{{ $sousChapitre->titre }}</span>
        </div>

        <!-- Titre -->
        <div class="mb-5">
            <p class="text-sm text-blue-600 font-medium">{{ $chapitre->titre }}</p>
            <h1 class="text-2xl font-bold text-gray-800 mt-1">
                {{ $sousChapitre->ordre ? $sousChapitre->ordre . '. ' : '' }}{{ $sousChapitre->titre }}
            </h1>
        </div>

        <!-- Contenu pédagogique -->
        <div class="bg-white rounded-xl shadow p-6 mb-5">
            @if($sousChapitre->contenu)
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line text-base">{{ $sousChapitre->contenu }}</div>
            @else
                <p class="text-gray-400 italic">Aucun contenu disponible.</p>
            @endif

            @if($sousChapitre->lien_ressource)
            <div class="mt-5 pt-5 border-t">
                <p class="text-sm font-semibold text-gray-600 mb-2">🔗 Ressource complémentaire</p>
                <a href="{{ $sousChapitre->lien_ressource }}" target="_blank"
                   class="inline-flex items-center gap-2 text-blue-600 hover:underline text-sm">
                    {{ $sousChapitre->lien_ressource }}
                    <span class="text-xs text-gray-400">(nouvel onglet)</span>
                </a>
            </div>
            @endif
        </div>

        <!-- Quiz associé -->
        @if($quiz)
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 mb-5">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-3xl">📝</span>
                <div>
                    <h2 class="text-lg font-bold text-purple-800">{{ $quiz->titre }}</h2>
                    <p class="text-sm text-purple-600">{{ $quiz->questions->count() }} question(s)</p>
                </div>
            </div>
            <a href="{{ route('quiz.passer', $quiz) }}"
               class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                🚀 Passer le quiz
            </a>
        </div>
        @endif

        <!-- Navigation Précédent / Suivant -->
        <div class="flex justify-between gap-3">
            @if($precedent)
            <a href="{{ route('apprenants.souschapitres.show', $precedent) }}"
               class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-3 rounded-xl hover:bg-gray-50 transition text-gray-700 font-medium text-sm">
                ← <span>{{ $precedent->titre }}</span>
            </a>
            @else
            <div></div>
            @endif

            @if($suivant)
            <a href="{{ route('apprenants.souschapitres.show', $suivant) }}"
               class="flex items-center gap-2 bg-blue-600 text-white px-4 py-3 rounded-xl hover:bg-blue-700 transition font-medium text-sm ml-auto">
                <span>{{ $suivant->titre }}</span> →
            </a>
            @endif
        </div>
    </div>
</div>

@endsection
