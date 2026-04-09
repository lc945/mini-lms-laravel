<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['sousChapitre.chapitre.formation', 'questions'])->get();
        return view('admin.quiz.index', compact('quizzes'));
    }

    public function create()
    {
        $souschapitres = SousChapitre::all();
        return view('admin.quiz.create', compact('souschapitres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        Quiz::create($validated);
        return redirect()->route('admin.quiz.index')->with('success', 'Quiz créé avec succès');
    }

    public function show(Quiz $quiz)
    {
        return view('admin.quiz.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        $souschapitres = SousChapitre::all();
        return view('admin.quiz.edit', compact('quiz', 'souschapitres'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $quiz->update($validated);
        return redirect()->route('admin.quiz.index')->with('success', 'Quiz mise à jour avec succès');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quiz.index')->with('success', 'Quiz supprimé avec succès');
    }

    public function passer(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('reponses')->get();
        return view('apprenants.quiz.passer', compact('quiz', 'questions'));
    }

    public function soumettre(Request $request, Quiz $quiz)
    {
        $score = 0;
        $total = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $reponseId = $request->input('question_' . $question->id);
            $bonne = $question->reponses()->where('est_correcte', true)->first();
            if ($bonne && $bonne->id == $reponseId) {
                $score++;
            }
        }

        $pourcentage = $total > 0 ? round(($score / $total) * 100) : 0;
        $noteSur20 = $total > 0 ? round(($score / $total) * 20, 2) : 0;

        // Récupérer le nom de la formation pour la matière
        $formation = $quiz->sousChapitre?->chapitre?->formation;
        $matiere = $formation ? $formation->nom . ' — ' . $quiz->titre : $quiz->titre;

        // Sauvegarder la note automatiquement
        \App\Models\Note::create([
            'user_id' => auth()->id(),
            'matiere' => $matiere,
            'note' => $noteSur20,
        ]);

        return view('apprenants.quiz.resultat', compact('score', 'total', 'pourcentage', 'quiz', 'noteSur20'));
    }
}
