<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('user')->get();
        return view('admin.notes.index', compact('notes'));
    }

    public function create()
    {
        $users = User::where('role', 'apprenant')->get();
        return view('admin.notes.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'matiere' => 'required|string|max:255',
            'note' => 'required|numeric|min:0|max:20',
        ]);

        Note::create($validated);
        return redirect()->route('admin.notes.index')->with('success', 'Note créée avec succès');
    }

    public function show(Note $note)
    {
        return view('admin.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $users = User::where('role', 'apprenant')->get();
        return view('admin.notes.edit', compact('note', 'users'));
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'matiere' => 'required|string|max:255',
            'note' => 'required|numeric|min:0|max:20',
        ]);

        $note->update($validated);
        return redirect()->route('admin.notes.index')->with('success', 'Note mise à jour avec succès');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('admin.notes.index')->with('success', 'Note supprimée avec succès');
    }

    public function mesNotes()
    {
        $notes = auth()->user()->notes;
        return view('apprenants.notes.index', compact('notes'));
    }
}
