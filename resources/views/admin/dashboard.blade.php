@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">👋 Bonjour, {{ auth()->user()->name }}</h1>
    <p class="text-gray-500 mt-1">Voici un aperçu de votre plateforme LMS.</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-blue-600 text-white rounded-xl p-5 shadow">
        <div class="text-3xl font-bold">{{ $stats['formations'] }}</div>
        <div class="text-blue-100 text-sm mt-1">📚 Formations</div>
    </div>
    <div class="bg-green-600 text-white rounded-xl p-5 shadow">
        <div class="text-3xl font-bold">{{ $stats['apprenants'] }}</div>
        <div class="text-green-100 text-sm mt-1">👥 Apprenants</div>
    </div>
    <div class="bg-purple-600 text-white rounded-xl p-5 shadow">
        <div class="text-3xl font-bold">{{ $stats['quiz'] }}</div>
        <div class="text-purple-100 text-sm mt-1">📝 Quiz</div>
    </div>
    <div class="bg-orange-500 text-white rounded-xl p-5 shadow">
        <div class="text-3xl font-bold">{{ $stats['notes'] }}</div>
        <div class="text-orange-100 text-sm mt-1">📊 Notes saisies</div>
    </div>
</div>

<!-- Actions rapides -->
<div class="mb-8">
    <h2 class="text-lg font-bold text-gray-700 mb-3">⚡ Actions rapides</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.ai.generate') }}"
           class="flex items-center gap-4 bg-purple-50 border-2 border-purple-200 rounded-xl p-5 hover:bg-purple-100 transition group">
            <span class="text-4xl">🤖</span>
            <div>
                <p class="font-bold text-purple-800 group-hover:text-purple-900">Générer avec l'IA</p>
                <p class="text-sm text-purple-600">Créer un cours complet en un prompt</p>
            </div>
        </a>
        <a href="{{ route('admin.formations.create') }}"
           class="flex items-center gap-4 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 hover:bg-blue-100 transition group">
            <span class="text-4xl">➕</span>
            <div>
                <p class="font-bold text-blue-800 group-hover:text-blue-900">Nouvelle formation</p>
                <p class="text-sm text-blue-600">Créer manuellement une formation</p>
            </div>
        </a>
        <a href="{{ route('admin.apprenants.index') }}"
           class="flex items-center gap-4 bg-green-50 border-2 border-green-200 rounded-xl p-5 hover:bg-green-100 transition group">
            <span class="text-4xl">👥</span>
            <div>
                <p class="font-bold text-green-800 group-hover:text-green-900">Gérer les apprenants</p>
                <p class="text-sm text-green-600">Assigner et suivre les apprenants</p>
            </div>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Formations récentes -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-700">📚 Formations récentes</h2>
            <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:underline text-sm">Voir tout →</a>
        </div>
        @forelse($formations as $f)
        <div class="flex justify-between items-center py-3 border-b last:border-0">
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $f->nom }}</p>
                <p class="text-xs text-gray-400">{{ $f->chapitres_count }} chapitre(s) · {{ $f->apprenants_count }} apprenant(s)</p>
            </div>
            <a href="{{ route('admin.formations.show', $f) }}" class="text-blue-600 hover:underline text-xs">Voir →</a>
        </div>
        @empty
        <p class="text-gray-400 text-sm italic">Aucune formation créée.</p>
        @endforelse
    </div>

    <!-- Dernières notes -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-700">📊 Dernières notes</h2>
            <a href="{{ route('admin.notes.index') }}" class="text-blue-600 hover:underline text-sm">Voir tout →</a>
        </div>
        @forelse($dernieresNotes as $note)
        <div class="flex justify-between items-center py-3 border-b last:border-0">
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $note->user->name }}</p>
                <p class="text-xs text-gray-400">{{ $note->matiere }}</p>
            </div>
            <span class="font-bold text-lg
                @if($note->note >= 14) text-green-600
                @elseif($note->note >= 10) text-orange-500
                @else text-red-500 @endif">
                {{ $note->note }}/20
            </span>
        </div>
        @empty
        <p class="text-gray-400 text-sm italic">Aucune note saisie.</p>
        @endforelse
    </div>
</div>

@endsection
