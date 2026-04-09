@extends('layouts.app')
@section('title', 'Générer un cours avec l\'IA')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux formations</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">🤖 Générer un cours complet avec l'IA</h1>
        <p class="text-gray-500 mt-1">Décrivez le cours souhaité en une phrase. L'IA génère automatiquement la formation, les chapitres, les contenus et les quiz.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.ai.generate') }}" class="bg-white rounded-lg shadow p-6" id="form-generate">
        @csrf

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Votre consigne *</label>
            <p class="text-xs text-gray-400 mb-2">Exemple : "Crée un cours sur le marketing au XXe siècle" ou "Explique la photosynthèse pour des lycéens"</p>
            <textarea name="prompt" rows="4" required
                      class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-purple-500 text-gray-700"
                      placeholder="Décrivez le cours que vous souhaitez générer...">{{ old('prompt') }}</textarea>
            @error('prompt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nombre de chapitres *</label>
                <select name="nb_chapitres" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                    @foreach([1,2,3] as $n)
                        <option value="{{ $n }}" @selected(old('nb_chapitres', 2) == $n)>{{ $n }} chapitre{{ $n > 1 ? 's' : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Niveau *</label>
                <select name="niveau" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                    @foreach(['Débutant','Intermédiaire','Avancé'] as $n)
                        <option value="{{ $n }}" @selected(old('niveau', 'Débutant') == $n)>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" id="btn-submit"
                class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-bold text-lg">
            🚀 Générer le cours complet
        </button>

        <div id="loading" class="hidden mt-4 text-center">
            <div class="inline-flex items-center gap-3 bg-purple-50 border border-purple-200 rounded-lg px-6 py-4">
                <svg class="animate-spin h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span class="text-purple-700 font-medium">L'IA génère votre cours complet... (30-60 secondes)</span>
            </div>
        </div>
    </form>

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
        <p class="font-semibold mb-1">💡 Ce qui sera généré automatiquement :</p>
        <ul class="list-disc list-inside space-y-1 text-blue-600">
            <li>La formation avec titre et description</li>
            <li>Les chapitres avec leur contenu pédagogique</li>
            <li>2 sous-chapitres par chapitre</li>
            <li>1 quiz de 3 questions par chapitre</li>
        </ul>
    </div>
</div>

<script>
document.getElementById('form-generate').addEventListener('submit', function() {
    document.getElementById('btn-submit').disabled = true;
    document.getElementById('btn-submit').textContent = '⏳ Génération en cours...';
    document.getElementById('loading').classList.remove('hidden');
});
</script>

@endsection
