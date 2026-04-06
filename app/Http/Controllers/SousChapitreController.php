<?php

namespace App\Http\Controllers;

use App\Models\SousChapitre;
use App\Models\Chapitre;
use Illuminate\Http\Request;

class SousChapitreController extends Controller
{
    public function index()
    {
        $souschapitres = SousChapitre::with(['chapitre.formation', 'quiz'])->get();
        return view('admin.souschapitres.index', compact('souschapitres'));
    }

    public function create()
    {
        $chapitres = Chapitre::all();
        return view('admin.souschapitres.create', compact('chapitres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'          => 'required|string|max:255',
            'contenu'        => 'nullable|string',
            'lien_ressource' => 'nullable|url|max:500',
            'chapitre_id'    => 'required|exists:chapitres,id',
            'ordre'          => 'nullable|integer',
        ]);

        SousChapitre::create($validated);
        return redirect()->route('admin.sous-chapitres.index')->with('success', 'Sous-chapitre créé avec succès');
    }

    public function show(SousChapitre $sousChapitre)
    {
        return view('admin.souschapitres.show', compact('sousChapitre'));
    }

    public function edit(SousChapitre $sousChapitre)
    {
        $chapitres = Chapitre::all();
        return view('admin.souschapitres.edit', compact('sousChapitre', 'chapitres'));
    }

    public function update(Request $request, SousChapitre $sousChapitre)
    {
        $validated = $request->validate([
            'titre'          => 'required|string|max:255',
            'contenu'        => 'nullable|string',
            'lien_ressource' => 'nullable|url|max:500',
            'chapitre_id'    => 'required|exists:chapitres,id',
            'ordre'          => 'nullable|integer',
        ]);

        $sousChapitre->update($validated);
        return redirect()->route('admin.sous-chapitres.index')->with('success', 'Sous-chapitre mise à jour avec succès');
    }

    public function destroy(SousChapitre $sousChapitre)
    {
        $sousChapitre->delete();
        return redirect()->route('admin.sous-chapitres.index')->with('success', 'Sous-chapitre supprimé avec succès');
    }
}
