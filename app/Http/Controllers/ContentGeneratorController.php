<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContentGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'formation' => 'nullable|string|max:255',
        ]);

        $apiKey = config('services.groq.key');
        if (!$apiKey) {
            return response()->json(['error' => 'Clé API non configurée.'], 500);
        }

        $prompt = "Tu es un expert pédagogique. Génère un contenu de cours structuré et clair en français pour un sous-chapitre intitulé : \"{$request->titre}\"";
        if ($request->formation) {
            $prompt .= ", dans le cadre de la formation : \"{$request->formation}\"";
        }
        $prompt .= ".\n\nLe contenu doit :\n- Être informatif et pédagogique\n- Faire entre 150 et 300 mots\n- Utiliser des listes à puces si pertinent\n- Être directement utilisable comme contenu de cours\n\nRéponds uniquement avec le contenu du cours, sans titre ni introduction.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama3-8b-8192',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Erreur API : ' . $response->status()], 500);
        }

        $content = $response->json('choices.0.message.content');

        return response()->json(['content' => $content]);
    }
}
