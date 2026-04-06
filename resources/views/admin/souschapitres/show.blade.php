@extends('layouts.app')
@section('title', $sousChapitre->titre)
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.chapitres.show', $sousChapitre->chapitre) }}" class="text-blue-600 hover:text-blue-800 text-sm">
            ← {{ $sousChapitre->chapitre->titre }}
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">
            📄 {{ $sousChapitre->ordre ? $sousChapitre->ordre.'. ' : '' }}{{ $sousChapitre->titre }}
        </h1>
        <p class="text-sm text-gray-500">{{ $sousChapitre->chapitre->formation->nom }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.sous-chapitres.edit', $sousChapitre) }}"
           class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">✏️ Modifier</a>
    </div>
</div>

<!-- Contenu pédagogique -->
<div class="bg-white rounded shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">📝 Contenu pédagogique</h2>
    @if($sousChapitre->contenu)
        <div class="prose max-w-none text-gray-700 whitespace-pre-line">{{ $sousChapitre->contenu }}</div>
    @else
        <p class="text-gray-400 italic">Aucun contenu renseigné.</p>
    @endif

    @if($sousChapitre->lien_ressource)
    <div class="mt-4 pt-4 border-t">
        <span class="text-xs text-gray-500 uppercase font-semibold">Ressource externe</span>
        <a href="{{ $sousChapitre->lien_ressource }}" target="_blank"
           class="flex items-center gap-2 mt-1 text-blue-600 hover:text-blue-800 hover:underline">
            🔗 {{ $sousChapitre->lien_ressource }}
        </a>
    </div>
    @endif
</div>

<!-- Quiz associé -->
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">📝 Quiz associé</h2>
        @if(!$sousChapitre->quiz)
            <a href="{{ route('admin.quiz.create') }}?sous_chapitre_id={{ $sousChapitre->id }}"
               class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition text-sm">+ Créer un quiz</a>
        @endif
    </div>

    @if($sousChapitre->quiz)
        <div class="border border-purple-200 rounded-lg p-4 bg-purple-50">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-purple-800">{{ $sousChapitre->quiz->titre }}</p>
                    <p class="text-sm text-purple-600">{{ $sousChapitre->quiz->questions->count() }} question(s)</p>
                </div>
                <a href="{{ route('admin.quiz.show', $sousChapitre->quiz) }}"
                   class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition text-sm">
                    Gérer le quiz →
                </a>
            </div>
        </div>
    @else
        <p class="text-gray-400 italic">Aucun quiz associé à ce sous-chapitre.</p>
    @endif
</div>

@endsection
