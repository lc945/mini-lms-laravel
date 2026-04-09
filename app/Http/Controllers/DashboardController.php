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
        $formations = Formation::withCount('chapitres')->latest()->get();

        $notes = $user->notes()->latest()->take(5)->get();
        $moyenneNotes = $user->notes()->avg('note');

        // Premier sous-chapitre disponible pour "Reprendre"
        $dernierSousChapitre = null;
        $premiereFormation = $formations->first();
        if ($premiereFormation) {
            $premierChapitre = $premiereFormation->chapitres()->orderBy('ordre')->first();
            if ($premierChapitre) {
                $dernierSousChapitre = $premierChapitre->souschapitres()->orderBy('ordre')->first();
            }
        }

        return view('apprenants.dashboard', compact('user', 'formations', 'notes', 'moyenneNotes', 'dernierSousChapitre'));
    }
}
