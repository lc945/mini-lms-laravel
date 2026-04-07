@extends('layouts.app')
@section('title', 'Nouveau Sous-chapitre')
@section('content')

<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.sous-chapitres.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour aux sous-chapitres</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">➕ Nouveau Sous-chapitre</h1>

    <form method="POST" action="{{ route('admin.sous-chapitres.store') }}" class="bg-white rounded shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Chapitre *</label>
            <select name="chapitre_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">Choisir un chapitre...</option>
                @foreach($chapitres as $c)
                    <option value="{{ $c->id }}" @selected(old('chapitre_id', request('chapitre_id')) == $c->id)>
                        {{ $c->formation->nom }} › {{ $c->titre }}
                    </option>
                @endforeach
            </select>
            @error('chapitre_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre *</label>
            <input type="text" name="titre" value="{{ old('titre') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Ex: Définition et importance">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Contenu pédagogique</label>
            <div class="flex items-center gap-3 mb-2">
                <p class="text-xs text-gray-500">Saisissez manuellement ou générez avec l'IA.</p>
                <button type="button" id="btn-generate"
                        onclick="genererContenu()"
                        data-apikey="{{ config('services.openai.key') }}"
                        class="flex items-center gap-2 bg-purple-600 text-white px-4 py-1.5 rounded-lg hover:bg-purple-700 transition text-sm font-semibold">
                    🤖 Générer avec l'IA
                </button>
                <span id="ia-loading" class="hidden text-purple-600 text-sm animate-pulse">⏳ Génération en cours (peut prendre 30s)...</span>
            </div>
            <textarea name="contenu" id="contenu" rows="10"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 font-mono text-sm"
                      placeholder="Saisissez ou collez le contenu pédagogique ici...">{{ old('contenu') }}</textarea>
            @error('contenu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Lien de ressource externe</label>
            <input type="url" name="lien_ressource" value="{{ old('lien_ressource') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="https://exemple.com/ressource">
            @error('lien_ressource') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Ordre</label>
            <input type="number" name="ordre" value="{{ old('ordre', 1) }}" min="1"
                   class="w-32 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('ordre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Créer le sous-chapitre
            </button>
            <a href="{{ route('admin.sous-chapitres.index') }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

<script>
function genererContenu() {
    const titre = document.querySelector('input[name="titre"]').value;
    const chapitreSelect = document.querySelector('select[name="chapitre_id"]');
    const formation = chapitreSelect.options[chapitreSelect.selectedIndex]?.text?.split('›')[0]?.trim() || '';
    const apiKey = document.getElementById('btn-generate').dataset.apikey;

    if (!titre) { alert('Veuillez d\'abord saisir le titre du sous-chapitre.'); return; }
    if (!apiKey) { alert('Clé API non configurée sur le serveur.'); return; }

    document.getElementById('btn-generate').disabled = true;
    document.getElementById('ia-loading').classList.remove('hidden');

    const prompt = `Tu es un expert pédagogique. Génère un contenu de cours structuré en français pour un sous-chapitre intitulé "${titre}"${formation ? ` dans la formation "${formation}"` : ''}. Le contenu doit faire 150-300 mots, utiliser des listes si pertinent. Réponds uniquement avec le contenu, sans titre.`;

    fetch('https://api.openai.com/v1/chat/completions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + apiKey,
        },
        body: JSON.stringify({
            model: 'gpt-3.5-turbo',
            messages: [{ role: 'user', content: prompt }],
        }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) { alert('Erreur OpenAI : ' + data.error.message); return; }
        document.getElementById('contenu').value = data.choices[0].message.content;
    })
    .catch(e => alert('Erreur : ' + e.message))
    .finally(() => {
        document.getElementById('btn-generate').disabled = false;
        document.getElementById('ia-loading').classList.add('hidden');
    });
}
</script>
@endsection
