<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Formation;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    public function index()
    {
        $chapitres = Chapitre::with(['formation', 'souschapitres'])->get();
        return view('admin.chapitres.index', compact('chapitres'));
    }

    public function create()
    {
        $formations = Formation::all();
        return view('admin.chapitres.create', compact('formations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formation_id' => 'required|exists:formations,id',
            'ordre' => 'nullable|integer',
        ]);

        Chapitre::create($validated);
        return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre créé avec succès');
    }

    public function show(Chapitre $chapitre)
    {
        return view('admin.chapitres.show', compact('chapitre'));
    }

    public function edit(Chapitre $chapitre)
    {
        $formations = Formation::all();
        return view('admin.chapitres.edit', compact('chapitre', 'formations'));
    }

    public function update(Request $request, Chapitre $chapitre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formation_id' => 'required|exists:formations,id',
            'ordre' => 'nullable|integer',
        ]);

        $chapitre->update($validated);
        return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre mise à jour avec succès');
    }

    public function destroy(Chapitre $chapitre)
    {
        $chapitre->delete();
        return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre supprimé avec succès');
    }
}
