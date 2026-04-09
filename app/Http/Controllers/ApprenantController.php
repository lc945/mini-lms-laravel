<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class ApprenantController extends Controller
{
    public function index()
    {
        $formations = Formation::withCount('chapitres')->get();
        return view('apprenants.formations.index', compact('formations'));
    }

    public function show(Formation $formation)
    {
        $chapitres = $formation->chapitres()->orderBy('ordre')->with(['souschapitres' => function ($q) {
            $q->orderBy('ordre');
        }])->get();
        return view('apprenants.formations.show', compact('formation', 'chapitres'));
    }

    public function showSousChapitre(SousChapitre $sousChapitre)
    {
        $chapitre = $sousChapitre->chapitre;
        $formation = $chapitre->formation;
        $quiz = $sousChapitre->quiz;

        // Construire la liste ordonnée de tous les sous-chapitres de la formation
        $tous = collect();
        foreach ($formation->chapitres()->orderBy('ordre')->get() as $ch) {
            foreach ($ch->souschapitres()->orderBy('ordre')->get() as $sc) {
                $tous->push($sc);
            }
        }

        $index = $tous->search(fn($sc) => $sc->id === $sousChapitre->id);
        $precedent = $index > 0 ? $tous[$index - 1] : null;
        $suivant = $index < $tous->count() - 1 ? $tous[$index + 1] : null;

        return view('apprenants.souschapitres.show', compact(
            'sousChapitre', 'quiz', 'chapitre', 'formation', 'precedent', 'suivant'
        ));
    }
}
