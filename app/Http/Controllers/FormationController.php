<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::all();
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|string',
            'duree' => 'nullable|integer',
        ]);

        Formation::create($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation créée avec succès');
    }

    public function show(Formation $formation)
    {
        return view('admin.formations.show', compact('formation'));
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|string',
            'duree' => 'nullable|integer',
        ]);

        $formation->update($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation mise à jour avec succès');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('admin.formations.index')->with('success', 'Formation supprimée avec succès');
    }
}
