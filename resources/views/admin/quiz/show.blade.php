@extends('layouts.app')
@section('title', $quiz->titre)
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.quiz.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux quiz</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">📝 {{ $quiz->titre }}</h1>
        <p class="text-sm text-gray-500">
            {{ $quiz->sousChapitre->chapitre->formation->nom }} ›
            {{ $quiz->sousChapitre->chapitre->titre }} ›
            {{ $quiz->sousChapitre->titre }}
        </p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.quiz.edit', $quiz) }}"
           class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">✏️ Modifier</a>
    </div>
</div>

<!-- Questions existantes -->
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">
        ❓ Questions ({{ $quiz->questions->count() }})
    </h2>

    @forelse($quiz->questions()->with('reponses')->get() as $i => $question)
    <div class="bg-white rounded shadow p-5 mb-4">
        <div class="flex justify-between items-start">
            <p class="font-semibold text-gray-800 flex-1">
                <span class="text-blue-600 mr-2">Q{{ $i + 1 }}.</span>{{ $question->question }}
            </p>
            <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="inline ml-4"
                  onsubmit="return confirm('Supprimer cette question ?');">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
            </form>
        </div>
        <div class="mt-3 grid grid-cols-2 gap-2">
            @foreach($question->reponses as $reponse)
            <div class="flex items-center gap-2 px-3 py-2 rounded border
                {{ $reponse->est_correcte ? 'bg-green-50 border-green-300 text-green-800' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                <span>{{ $reponse->est_correcte ? '✅' : '○' }}</span>
                <span class="text-sm">{{ $reponse->texte }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @empty
        <div class="bg-gray-50 rounded p-6 text-center text-gray-500 mb-4">
            Aucune question. Ajoutez-en une ci-dessous.
        </div>
    @endforelse
</div>

<!-- Formulaire d'ajout de question -->
<div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">➕ Ajouter une question</h2>

    <form method="POST" action="{{ route('admin.questions.store', $quiz) }}" id="form-question">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Question *</label>
            <input type="text" name="question" value="{{ old('question') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Ex: Quel est le prétérit de GO ?">
            @error('question') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Réponses possibles *</label>
            <p class="text-xs text-gray-500 mb-3">Cochez la bonne réponse. Minimum 2 réponses.</p>

            <div id="reponses-container" class="space-y-2">
                @for($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-3">
                    <input type="radio" name="bonne_reponse" value="{{ $i }}"
                           @checked(old('bonne_reponse') == $i)
                           class="w-4 h-4 text-green-600 cursor-pointer"
                           title="Cocher pour marquer comme bonne réponse">
                    <input type="text" name="reponses[{{ $i }}]" value="{{ old('reponses.'.$i) }}"
                           class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Réponse {{ $i + 1 }}{{ $i === 0 ? ' (obligatoire)' : '' }}">
                </div>
                @endfor
            </div>
            @error('reponses') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            @error('bonne_reponse') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            <p class="text-xs text-gray-400 mt-2">Le bouton radio ○ permet de sélectionner la bonne réponse.</p>
        </div>

        <button type="submit" class="w-full bg-purple-600 text-white px-6 py-3 rounded hover:bg-purple-700 transition font-semibold">
            ✅ Ajouter la question
        </button>
    </form>
</div>

@endsection
