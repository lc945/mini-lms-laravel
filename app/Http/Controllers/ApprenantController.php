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
        $quiz = $sousChapitre->quiz;
        $chapitre = $sousChapitre->chapitre;
        $formation = $chapitre->formation;
        return view('apprenants.souschapitres.show', compact('sousChapitre', 'quiz', 'chapitre', 'formation'));
    }
}
