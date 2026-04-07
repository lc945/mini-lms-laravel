@extends('layouts.app')
@section('title', 'Modifier Sous-chapitre')
@section('content')

<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.sous-chapitres.show', $sousChapitre) }}" class="text-blue-600 hover:text-blue-800 text-sm">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-2">✏️ Modifier le Sous-chapitre</h1>

    <form method="POST" action="{{ route('admin.sous-chapitres.update', $sousChapitre) }}" class="bg-white rounded shadow p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Chapitre *</label>
            <select name="chapitre_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                @foreach($chapitres as $c)
                    <option value="{{ $c->id }}" @selected(old('chapitre_id', $sousChapitre->chapitre_id) == $c->id)>
                        {{ $c->formation->nom }} › {{ $c->titre }}
                    </option>
                @endforeach
            </select>
            @error('chapitre_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Titre *</label>
            <input type="text" name="titre" value="{{ old('titre', $sousChapitre->titre) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Contenu pédagogique</label>
            <div class="flex items-center gap-3 mb-2">
                <p class="text-xs text-gray-500">Saisissez manuellement ou régénérez avec l'IA.</p>
                <button type="button" id="btn-generate"
                        onclick="genererContenu()"
                        class="flex items-center gap-2 bg-purple-600 text-white px-4 py-1.5 rounded-lg hover:bg-purple-700 transition text-sm font-semibold">
                    🤖 Générer avec l'IA
                </button>
                <span id="ia-loading" class="hidden text-purple-600 text-sm animate-pulse">⏳ Génération en cours (peut prendre 30s)...</span>
            </div>
            <textarea name="contenu" id="contenu" rows="10"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 font-mono text-sm">{{ old('contenu', $sousChapitre->contenu) }}</textarea>
            @error('contenu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Lien de ressource externe</label>
            <input type="url" name="lien_ressource" value="{{ old('lien_ressource', $sousChapitre->lien_ressource) }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="https://exemple.com/ressource">
            @error('lien_ressource') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Ordre</label>
            <input type="number" name="ordre" value="{{ old('ordre', $sousChapitre->ordre) }}" min="1"
                   class="w-32 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('ordre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                ✅ Mettre à jour
            </button>
            <a href="{{ route('admin.sous-chapitres.show', $sousChapitre) }}" class="flex-1 bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition text-center font-semibold">
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

    if (!titre) { alert('Veuillez d\'abord saisir le titre du sous-chapitre.'); return; }

    document.getElementById('btn-generate').disabled = true;
    document.getElementById('ia-loading').classList.remove('hidden');

    fetch('/admin/generate-content', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ titre, formation }),
    })
    .then(r => r.text().then(text => {
        try {
            const data = JSON.parse(text);
            if (data.error) { alert('Erreur : ' + data.error); return; }
            document.getElementById('contenu').value = data.content;
        } catch(e) {
            alert('Erreur serveur (' + r.status + '). Vérifiez la clé OPENAI_API_KEY sur Render.');
        }
    }))
    .catch(e => alert('Erreur : ' + e.message))
    .finally(() => {
        document.getElementById('btn-generate').disabled = false;
        document.getElementById('ia-loading').classList.add('hidden');
    });
}
</script>
@endsection
