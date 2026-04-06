<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question'          => 'required|string|max:500',
            'reponses'          => 'required|array|min:2',
            'reponses.*'        => 'required|string|max:255',
            'bonne_reponse'     => 'required|integer|min:0',
        ]);

        $question = Question::create([
            'question' => $validated['question'],
            'quiz_id'  => $quiz->id,
        ]);

        foreach ($validated['reponses'] as $index => $texte) {
            if (trim($texte) === '') continue;
            Reponse::create([
                'texte'        => $texte,
                'est_correcte' => ($index == $validated['bonne_reponse']),
                'question_id'  => $question->id,
            ]);
        }

        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Question ajoutée avec succès');
    }

    public function destroy(Question $question)
    {
        $quiz = $question->quiz;
        $question->delete();
        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Question supprimée');
    }
}
