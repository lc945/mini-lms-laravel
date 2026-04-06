<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminApprenantController extends Controller
{
    public function index()
    {
        $apprenants = User::where('role', 'apprenant')->with('formation')->get();
        return view('admin.apprenants.index', compact('apprenants'));
    }

    public function show(User $apprenant)
    {
        $apprenant->load(['formation', 'notes']);
        return view('admin.apprenants.show', compact('apprenant'));
    }

    public function edit(User $apprenant)
    {
        $formations = Formation::all();
        return view('admin.apprenants.edit', compact('apprenant', 'formations'));
    }

    public function update(Request $request, User $apprenant)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $apprenant->id,
            'formation_id' => 'nullable|exists:formations,id',
        ]);

        $apprenant->update($validated);
        return redirect()->route('admin.apprenants.index')->with('success', 'Apprenant mis à jour avec succès');
    }

    public function destroy(User $apprenant)
    {
        $apprenant->delete();
        return redirect()->route('admin.apprenants.index')->with('success', 'Apprenant supprimé');
    }
}
