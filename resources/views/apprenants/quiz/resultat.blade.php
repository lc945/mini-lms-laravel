@extends('layouts.app')
@section('title', 'Résultat du Quiz')
@section('content')

<div class="bg-white rounded shadow p-8 text-center max-w-md mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6">🎯 Résultat du quiz</h1>
    
    <div class="text-7xl font-bold mb-4 @if($pourcentage >= 70) text-green-500 @elseif($pourcentage >= 50) text-yellow-500 @else text-red-500 @endif">
        {{ $pourcentage }}%
    </div>

    <p class="text-gray-600 text-lg mb-6">
        Tu as eu <strong>{{ $score }}</strong> bonne(s) réponse(s) sur <strong>{{ $total }}</strong>.
    </p>

    @if($pourcentage >= 70)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-green-700 font-semibold text-lg">🎉 Excellent travail !</p>
        </div>
    @elseif($pourcentage >= 50)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-yellow-700 font-semibold text-lg">👍 Pas mal, continue !</p>
        </div>
    @else
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <p class="text-red-700 font-semibold text-lg">💪 Révise et réessaie !</p>
        </div>
    @endif

    <div class="flex gap-4 mt-8">
        <a href="{{ route('apprenants.formations') }}" 
           class="flex-1 bg-blue-600 text-white px-5 py-3 rounded hover:bg-blue-700 transition font-semibold">
            ← Retour aux formations
        </a>
        <a href="{{ route('quiz.passer', $quiz) }}" 
           class="flex-1 bg-gray-400 text-white px-5 py-3 rounded hover:bg-gray-500 transition font-semibold">
            🔄 Recommencer
        </a>
    </div>
</div>

@endsection
