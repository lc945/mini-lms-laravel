@extends('layouts.app')
@section('title', 'Apprenants')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">👥 Apprenants</h1>
    <span class="text-sm text-gray-500 bg-white px-3 py-2 rounded shadow">{{ $apprenants->count() }} apprenant(s)</span>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="px-6 py-4 text-left font-semibold">Nom</th>
                <th class="px-6 py-4 text-left font-semibold">Email</th>
                <th class="px-6 py-4 text-left font-semibold">Formation assignée</th>
                <th class="px-6 py-4 text-left font-semibold">Notes</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($apprenants as $apprenant)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $apprenant->name }}</td>
                <td class="px-6 py-4 text-gray-600 text-sm">{{ $apprenant->email }}</td>
                <td class="px-6 py-4">
                    @if($apprenant->formation)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                            {{ $apprenant->formation->nom }}
                        </span>
                    @else
                        <span class="text-gray-400 text-sm italic">Non assigné</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $apprenant->notes->count() }} note(s)</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.apprenants.show', $apprenant) }}"
                           class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition">👁️</a>
                        <a href="{{ route('admin.apprenants.edit', $apprenant) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500 transition">✏️</a>
                        <form method="POST" action="{{ route('admin.apprenants.destroy', $apprenant) }}" class="inline"
                              onsubmit="return confirm('Supprimer cet apprenant ?');">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Aucun apprenant inscrit.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
