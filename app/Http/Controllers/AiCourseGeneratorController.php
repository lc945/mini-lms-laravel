<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Formation;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use App\Models\SousChapitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiCourseGeneratorController extends Controller
{
    public function index()
    {
        return view('admin.ai.generate');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
        ]);

        $apiKey = config('services.groq.key');
        if (!$apiKey) {
            return back()->with('error', 'Clé API Groq non configurée.');
        }

        $systemPrompt = 'Tu es un expert en ingénierie pédagogique. Analyse la demande de l\'utilisateur et génère un cours complet en français. Retourne UNIQUEMENT un JSON valide sans markdown. Détermine toi-même le nombre de chapitres, le niveau (Débutant, Intermédiaire ou Avancé) et la durée selon la demande. Structure JSON : {"formation":{"nom":"","description":"","niveau":"Débutant|Intermédiaire|Avancé","duree":3},"chapitres":[{"titre":"","description":"","sous_chapitres":[{"titre":"","contenu":"contenu pédagogique de 100 mots avec exemples concrets"}],"quiz":{"titre":"","questions":[{"question":"","reponses":["A","B","C"],"bonne_reponse":0}]}}]}. Chaque chapitre : 1 sous-chapitre, 2 questions de quiz. Maximum 3 chapitres pour rester concis.';

        $payload = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $request->prompt],
            ],
            'max_tokens' => 2000,
            'temperature' => 0.7,
        ];

        // Retry automatique si 429
        $response = null;
        for ($attempt = 0; $attempt < 3; $attempt++) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post('https://api.groq.com/openai/v1/chat/completions', $payload);

            if ($response->status() !== 429) break;
            sleep(20);
        }

        if ($response->failed()) {
            $errorMsg = $response->json('error.message') ?? $response->body();
            return back()->with('error', 'Erreur API Groq ' . $response->status() . ' : ' . $errorMsg);
        }

        $text = $response->json('choices.0.message.content');

        // Nettoyer les blocs markdown éventuels
        $text = preg_replace('/```json\s*/i', '', $text);
        $text = preg_replace('/```\s*/i', '', $text);
        $text = trim($text);

        // Extraire le JSON
        preg_match('/\{.*\}/s', $text, $matches);
        if (empty($matches)) {
            return back()->with('error', 'L\'IA n\'a pas retourné un JSON valide. Réessayez dans 1 minute.');
        }

        $data = json_decode($matches[0], true);
        if (!$data || !isset($data['formation'], $data['chapitres'])) {
            return back()->with('error', 'Structure JSON invalide. Réponse reçue : ' . substr($matches[0], 0, 200));
        }

        // Créer la formation
        $formation = Formation::create([
            'nom' => $data['formation']['nom'],
            'description' => $data['formation']['description'],
            'niveau' => $data['formation']['niveau'],
            'duree' => $data['formation']['duree'] ?? 3,
        ]);

        // Créer chapitres, sous-chapitres et quiz
        foreach ($data['chapitres'] as $ordre => $chapitreData) {
            $chapitre = Chapitre::create([
                'titre' => $chapitreData['titre'],
                'description' => $chapitreData['description'] ?? '',
                'formation_id' => $formation->id,
                'ordre' => $ordre + 1,
            ]);

            foreach ($chapitreData['sous_chapitres'] as $scOrdre => $scData) {
                $sousChapitre = SousChapitre::create([
                    'titre' => $scData['titre'],
                    'contenu' => $scData['contenu'],
                    'chapitre_id' => $chapitre->id,
                    'ordre' => $scOrdre + 1,
                ]);

                // Quiz sur le dernier sous-chapitre du chapitre
                if ($scOrdre === count($chapitreData['sous_chapitres']) - 1 && isset($chapitreData['quiz'])) {
                    $quiz = Quiz::create([
                        'titre' => $chapitreData['quiz']['titre'],
                        'sous_chapitre_id' => $sousChapitre->id,
                    ]);

                    foreach ($chapitreData['quiz']['questions'] as $qData) {
                        $question = Question::create([
                            'question' => $qData['question'],
                            'quiz_id' => $quiz->id,
                        ]);

                        foreach ($qData['reponses'] as $i => $texte) {
                            Reponse::create([
                                'texte' => $texte,
                                'est_correcte' => ($i === $qData['bonne_reponse']),
                                'question_id' => $question->id,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.formations.show', $formation)
            ->with('success', 'Formation "' . $formation->nom . '" générée avec succès par l\'IA !');
    }
}
