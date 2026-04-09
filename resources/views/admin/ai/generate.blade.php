@extends('layouts.app')
@section('title', 'Générer un cours avec l\'IA')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Tableau de bord</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">🤖 Générer un cours avec l'IA</h1>
        <p class="text-gray-500 mt-1">Décrivez librement le cours souhaité. L'IA génère automatiquement la formation complète, les chapitres, les contenus et les quiz.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
    @endif

    <!-- Exemples cliquables -->
    <div class="mb-5">
        <p class="text-xs font-bold text-gray-400 uppercase mb-2">💡 Exemples de prompts — cliquez pour l'utiliser</p>
        <div class="flex flex-wrap gap-2">
            @foreach([
                'Explique le marketing au XXe siècle en 3 chapitres pour des étudiants en école de commerce.',
                'Crée un cours sur les bases de Python pour des débutants complets en 2 chapitres.',
                'Introduction à la photosynthèse pour des lycéens en 2 chapitres avec quiz.',
                'Les verbes irréguliers en anglais pour des élèves de collège en 3 chapitres.',
            ] as $exemple)
            <button type="button"
                    onclick="document.getElementById('prompt').value = this.dataset.prompt"
                    data-prompt="{{ $exemple }}"
                    class="text-xs bg-purple-50 border border-purple-200 text-purple-700 px-3 py-1.5 rounded-full hover:bg-purple-100 transition text-left">
                {{ $exemple }}
            </button>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('admin.ai.generate') }}" class="bg-white rounded-xl shadow p-6" id="form-generate">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Votre consigne *</label>
            <textarea name="prompt" id="prompt" rows="4" required
                      class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:border-purple-500 text-gray-700 text-base"
                      placeholder="Ex : Crée un cours sur le marketing digital en 3 chapitres pour des débutants...">{{ old('prompt') }}</textarea>
            @error('prompt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" id="btn-submit"
                class="w-full bg-purple-600 text-white py-3 rounded-xl hover:bg-purple-700 transition font-bold text-lg">
            🚀 Générer le cours complet
        </button>

        <div id="loading" class="hidden mt-5">
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-5">
                <!-- Barre de progression animée -->
                <div class="w-full bg-purple-200 rounded-full h-2 mb-3 overflow-hidden">
                    <div class="bg-purple-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                </div>
                <div class="flex items-center gap-3 justify-center">
                    <svg class="animate-spin h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <span class="text-purple-700 font-medium" id="loading-text">L'IA génère votre cours...</span>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
        <p class="font-semibold mb-1">💡 Ce qui sera généré automatiquement :</p>
        <ul class="list-disc list-inside space-y-1 text-blue-600">
            <li>Titre, description et niveau de la formation</li>
            <li>Chapitres avec contenus pédagogiques détaillés</li>
            <li>Un quiz avec questions/réponses par chapitre</li>
        </ul>
    </div>
</div>

<script>
let loadingMessages = [
    "L'IA génère votre cours...",
    "Création des chapitres en cours...",
    "Génération des quiz...",
    "Finalisation du contenu...",
];
let msgIndex = 0;

document.getElementById('form-generate').addEventListener('submit', function() {
    document.getElementById('btn-submit').disabled = true;
    document.getElementById('btn-submit').textContent = '⏳ Génération en cours...';
    document.getElementById('loading').classList.remove('hidden');

    setInterval(() => {
        msgIndex = (msgIndex + 1) % loadingMessages.length;
        document.getElementById('loading-text').textContent = loadingMessages[msgIndex];
    }, 3000);
});
</script>

@endsection
