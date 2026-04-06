@extends('layouts.app')
@section('title', 'Passer un Quiz')
@section('content')

<h1 class="text-2xl font-bold mb-6">📝 {{ $quiz->titre }}</h1>

<form method="POST" action="{{ route('quiz.soumettre', $quiz) }}" class="space-y-6">
    @csrf
    @foreach($questions as $i => $question)
    <div class="bg-white rounded shadow p-5">
        <p class="font-semibold text-gray-800 mb-4 text-lg">
            <strong>Question {{ $i + 1 }}/{{ $questions->count() }}</strong>
        </p>
        <p class="text-gray-800 mb-4">{{ $question->question }}</p>

        <div class="space-y-3">
            @foreach($question->reponses as $reponse)
            <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 p-3 rounded border border-gray-200 transition">
                <input type="radio" 
                       name="question_{{ $question->id }}" 
                       value="{{ $reponse->id }}" 
                       required
                       class="form-radio text-blue-600 w-4 h-4">
                <span class="text-gray-700">{{ $reponse->texte }}</span>
            </label>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="flex gap-4">
        <a href="{{ route('apprenants.formations') }}" 
           class="flex-1 bg-gray-400 text-white px-6 py-3 rounded hover:bg-gray-500 transition text-center font-semibold">
            ❌ Annuler
        </a>
        <button type="submit" 
                class="flex-1 bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition font-semibold">
            ✅ Soumettre mes réponses
        </button>
    </div>
</form>

@endsection
