<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Note;
use App\Models\Quiz;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'formations' => Formation::count(),
            'apprenants' => User::where('role', 'apprenant')->count(),
            'quiz' => Quiz::count(),
            'notes' => Note::count(),
        ];

        $formations = Formation::withCount(['chapitres', 'apprenants'])->latest()->take(5)->get();
        $dernieresNotes = Note::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'formations', 'dernieresNotes'));
    }

    public function apprenant()
    {
        $user = auth()->user();
        $formation = $user->formation ? $user->formation->load([
            'chapitres.souschapitres.quiz'
        ]) : null;

        $notes = $user->notes()->latest()->take(5)->get();
        $moyenneNotes = $user->notes()->avg('note');

        // Dernier sous-chapitre consulté
        $dernierSousChapitre = null;
        if ($formation) {
            foreach ($formation->chapitres as $chapitre) {
                foreach ($chapitre->souschapitres as $sc) {
                    $dernierSousChapitre = $sc;
                    break 2;
                }
            }
        }

        return view('apprenants.dashboard', compact('user', 'formation', 'notes', 'moyenneNotes', 'dernierSousChapitre'));
    }
}
