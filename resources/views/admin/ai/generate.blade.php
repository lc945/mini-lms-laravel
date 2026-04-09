@extends('layouts.app')
@section('title', 'Générer un cours avec l\'IA')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux formations</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">🤖 Générer un cours avec l'IA</h1>
        <p class="text-gray-500 mt-1">Décrivez librement le cours souhaité. L'IA génère automatiquement la formation complète, les chapitres, les contenus et les quiz.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.ai.generate') }}" class="bg-white rounded-lg shadow p-6" id="form-generate">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Votre consigne *</label>
            <p class="text-xs text-gray-400 mb-3">Exemples :<br>
                "Explique le marketing au XXe siècle en 3 chapitres avec un quiz pour débutants."<br>
                "Crée un cours sur la photosynthèse en 2 chapitres pour lycéens."
            </p>
            <textarea name="prompt" rows="5" required
                      class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-purple-500 text-gray-700 text-base"
                      placeholder="Décrivez le cours que vous souhaitez générer...">{{ old('prompt') }}</textarea>
            @error('prompt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
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
                <span class="text-purple-700 font-medium">L'IA génère votre cours... (30-60 secondes)</span>
            </div>
        </div>
    </form>

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
        <p class="font-semibold mb-1">💡 Ce qui sera généré automatiquement :</p>
        <ul class="list-disc list-inside space-y-1 text-blue-600">
            <li>La formation avec titre, description et niveau</li>
            <li>Les chapitres avec contenus pédagogiques</li>
            <li>Un quiz avec questions/réponses par chapitre</li>
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
