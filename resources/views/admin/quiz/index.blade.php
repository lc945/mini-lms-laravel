@extends('layouts.app')
@section('title', 'Quiz')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📝 Quiz</h1>
    <a href="{{ route('admin.quiz.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Nouveau quiz</a>
</div>

<div class="grid gap-4">
    @forelse($quizzes as $quiz)
    <div class="bg-white rounded shadow p-5 flex justify-between items-start hover:shadow-lg transition">
        <div class="flex-1">
            <p class="text-xs text-purple-500 font-medium mb-1">
                {{ $quiz->sousChapitre->chapitre->formation->nom }} ›
                {{ $quiz->sousChapitre->chapitre->titre }} ›
                {{ $quiz->sousChapitre->titre }}
            </p>
            <h2 class="text-lg font-semibold text-gray-800">{{ $quiz->titre }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $quiz->questions->count() }} question(s)</p>
        </div>
        <div class="flex gap-2 ml-4">
            <a href="{{ route('admin.quiz.show', $quiz) }}"
               class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm hover:bg-purple-200 transition">📝 Gérer</a>
            <a href="{{ route('admin.quiz.edit', $quiz) }}"
               class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">✏️</a>
            <form method="POST" action="{{ route('admin.quiz.destroy', $quiz) }}" class="inline"
                  onsubmit="return confirm('Supprimer ce quiz et toutes ses questions ?');">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
            </form>
        </div>
    </div>
    @empty
        <p class="text-gray-500 text-center py-10 bg-white rounded shadow">
            Aucun quiz. <a href="{{ route('admin.quiz.create') }}" class="text-blue-600 hover:underline">Créer le premier</a>
        </p>
    @endforelse
</div>

@endsection
