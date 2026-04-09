@extends('layouts.app')
@section('title', 'Résultat du Quiz')
@section('content')

<div class="max-w-lg mx-auto mt-6">
    <div class="bg-white rounded-xl shadow p-8 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">🎯 Résultat du quiz</h1>

        <!-- Score circulaire -->
        <div class="inline-flex items-center justify-center w-36 h-36 rounded-full border-8 mb-6
            @if($pourcentage >= 70) border-green-500
            @elseif($pourcentage >= 50) border-orange-400
            @else border-red-500 @endif">
            <div>
                <div class="text-4xl font-bold
                    @if($pourcentage >= 70) text-green-600
                    @elseif($pourcentage >= 50) text-orange-500
                    @else text-red-500 @endif">
                    {{ $pourcentage }}%
                </div>
                <div class="text-xs text-gray-500">score</div>
            </div>
        </div>

        <p class="text-gray-600 text-lg mb-2">
            <strong>{{ $score }}</strong> bonne(s) réponse(s) sur <strong>{{ $total }}</strong>
        </p>

        @if($pourcentage >= 70)
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 mt-4">
            <p class="text-green-700 font-bold text-xl">🎉 Excellent travail !</p>
            <p class="text-green-600 text-sm mt-1">Vous maîtrisez bien ce sujet. Continuez comme ça !</p>
        </div>
        @elseif($pourcentage >= 50)
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6 mt-4">
            <p class="text-orange-700 font-bold text-xl">👍 Pas mal !</p>
            <p class="text-orange-600 text-sm mt-1">Vous progressez bien, relisez le cours pour consolider.</p>
        </div>
        @else
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 mt-4">
            <p class="text-red-700 font-bold text-xl">💪 Courage !</p>
            <p class="text-red-600 text-sm mt-1">Relisez le cours attentivement et réessayez.</p>
        </div>
        @endif

        <div class="flex gap-3 mt-6">
            @if($quiz->sousChapitre)
            <a href="{{ route('apprenants.souschapitres.show', $quiz->sousChapitre) }}"
               class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
                ← Retour au cours
            </a>
            @else
            <a href="{{ route('apprenants.formations') }}"
               class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
                ← Mes formations
            </a>
            @endif
            <a href="{{ route('quiz.passer', $quiz) }}"
               class="flex-1 bg-gray-400 text-white px-4 py-3 rounded-lg hover:bg-gray-500 transition font-semibold text-sm">
                🔄 Recommencer
            </a>
        </div>
    </div>
</div>

@endsection
