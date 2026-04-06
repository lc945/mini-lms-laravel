@extends('layouts.app')
@section('title', $apprenant->name)
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.apprenants.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux apprenants</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">👤 {{ $apprenant->name }}</h1>
        <p class="text-gray-500 text-sm">{{ $apprenant->email }}</p>
    </div>
    <a href="{{ route('admin.apprenants.edit', $apprenant) }}"
       class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">✏️ Modifier</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
        <div class="space-y-3">
            <div>
                <span class="text-xs text-gray-500 uppercase font-semibold">Formation assignée</span>
                <p class="text-gray-800 font-medium mt-1">
                    @if($apprenant->formation)
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $apprenant->formation->nom }}</span>
                    @else
                        <span class="text-gray-400 italic text-sm">Aucune formation assignée</span>
                    @endif
                </p>
            </div>
            <div>
                <span class="text-xs text-gray-500 uppercase font-semibold">Inscrit le</span>
                <p class="text-gray-700">{{ $apprenant->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">📊 Notes ({{ $apprenant->notes->count() }})</h2>
        @forelse($apprenant->notes as $note)
        <div class="flex justify-between items-center py-2 border-b last:border-0">
            <span class="text-gray-700 text-sm">{{ $note->matiere }}</span>
            <span class="font-bold text-blue-600">{{ number_format($note->note, 2) }}/20</span>
        </div>
        @empty
            <p class="text-gray-400 italic text-sm">Aucune note.</p>
        @endforelse
        @if($apprenant->notes->count() > 0)
        <div class="mt-3 pt-3 border-t flex justify-between">
            <span class="text-sm font-semibold text-gray-600">Moyenne</span>
            <span class="font-bold text-blue-700">{{ number_format($apprenant->notes->avg('note'), 2) }}/20</span>
        </div>
        @endif
    </div>
</div>

@endsection
