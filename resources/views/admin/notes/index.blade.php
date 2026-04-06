@extends('layouts.app')
@section('title', 'Notes')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📊 Notes des apprenants</h1>
    <a href="{{ route('admin.notes.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Ajouter une note</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="px-6 py-4 text-left font-semibold">Apprenant</th>
                <th class="px-6 py-4 text-left font-semibold">Matière / Module</th>
                <th class="px-6 py-4 text-left font-semibold">Note</th>
                <th class="px-6 py-4 text-left font-semibold">Date</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($notes as $note)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $note->user->name }}</td>
                <td class="px-6 py-4 text-gray-700">{{ $note->matiere }}</td>
                <td class="px-6 py-4">
                    <span class="text-xl font-bold
                        @if($note->note >= 14) text-green-600
                        @elseif($note->note >= 10) text-yellow-600
                        @else text-red-600 @endif">
                        {{ number_format($note->note, 2) }}<span class="text-sm text-gray-400">/20</span>
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $note->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.notes.edit', $note) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">✏️</a>
                        <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" class="inline"
                              onsubmit="return confirm('Supprimer cette note ?');">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Aucune note enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
