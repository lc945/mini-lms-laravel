@extends('layouts.app')
@section('title', $quiz->titre)
@section('content')

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">📝 {{ $quiz->titre }}</h1>

    <!-- Barre de progression -->
    <div class="flex items-center gap-3 mb-6">
        <span class="text-sm text-gray-500 whitespace-nowrap" id="progress-label">Question 1/{{ count($questions) }}</span>
        <div class="flex-1 bg-gray-200 rounded-full h-2">
            <div id="progress-bar" class="bg-purple-600 h-2 rounded-full transition-all duration-500"
                 style="width: {{ count($questions) > 0 ? round(1/count($questions)*100) : 0 }}%"></div>
        </div>
    </div>

    <!-- Questions une par une -->
    @foreach($questions as $index => $question)
    <div class="question-card {{ $index > 0 ? 'hidden' : '' }}" id="question-{{ $index }}">
        <div class="bg-white rounded-xl shadow p-6 mb-4">
            <p class="text-lg font-semibold text-gray-800 mb-5">{{ $question->question }}</p>
            <div class="space-y-3">
                @foreach($question->reponses as $reponse)
                <button type="button"
                        class="reponse-btn w-full text-left px-5 py-3 rounded-lg border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 transition font-medium text-gray-700"
                        data-correct="{{ $reponse->est_correcte ? '1' : '0' }}"
                        data-reponse-id="{{ $reponse->id }}"
                        data-question-id="{{ $question->id }}"
                        onclick="choisirReponse(this, {{ $index }}, {{ count($questions) }})">
                    {{ $reponse->texte }}
                </button>
                @endforeach
            </div>
            <div id="feedback-{{ $index }}" class="hidden mt-4 p-4 rounded-lg font-semibold text-center"></div>
        </div>
        <div id="next-{{ $index }}" class="hidden text-right mb-6">
            @if($index < count($questions) - 1)
            <button onclick="questionSuivante({{ $index }}, {{ count($questions) }})"
                    class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                Question suivante →
            </button>
            @else
            <button onclick="terminerQuiz()"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                ✅ Voir mes résultats
            </button>
            @endif
        </div>
    </div>
    @endforeach

    <form id="form-quiz" method="POST" action="{{ route('quiz.soumettre', $quiz) }}" class="hidden">
        @csrf
        @foreach($questions as $question)
        <input type="hidden" name="question_{{ $question->id }}" id="rep-{{ $question->id }}" value="">
        @endforeach
    </form>
</div>

<script>
const reponses = {};
const questionIds = @json($questions->pluck('id'));

function choisirReponse(btn, questionIndex, total) {
    const card = document.getElementById('question-' + questionIndex);
    const allBtns = card.querySelectorAll('.reponse-btn');
    allBtns.forEach(b => b.disabled = true);

    const correct = btn.dataset.correct === '1';
    reponses[btn.dataset.questionId] = btn.dataset.reponseId;

    allBtns.forEach(b => {
        if (b.dataset.correct === '1') {
            b.classList.add('border-green-500', 'bg-green-50', 'text-green-700');
        } else if (b === btn && !correct) {
            b.classList.add('border-red-500', 'bg-red-50', 'text-red-700');
        }
    });

    const feedback = document.getElementById('feedback-' + questionIndex);
    feedback.classList.remove('hidden');
    if (correct) {
        feedback.className = 'mt-4 p-4 rounded-lg font-semibold text-center bg-green-100 text-green-700';
        feedback.textContent = '✅ Bonne réponse !';
    } else {
        const bonne = Array.from(allBtns).find(b => b.dataset.correct === '1').textContent.trim();
        feedback.className = 'mt-4 p-4 rounded-lg font-semibold text-center bg-red-100 text-red-700';
        feedback.textContent = '❌ Mauvaise réponse. La bonne réponse était : ' + bonne;
    }
    document.getElementById('next-' + questionIndex).classList.remove('hidden');
}

function questionSuivante(current, total) {
    document.getElementById('question-' + current).classList.add('hidden');
    const next = current + 1;
    document.getElementById('question-' + next).classList.remove('hidden');
    document.getElementById('progress-label').textContent = 'Question ' + (next + 1) + '/' + total;
    document.getElementById('progress-bar').style.width = ((next + 1) / total * 100) + '%';
}

function terminerQuiz() {
    questionIds.forEach(qId => {
        const input = document.getElementById('rep-' + qId);
        if (input) input.value = reponses[qId] || '';
    });
    document.getElementById('form-quiz').submit();
}
</script>
@endsection
