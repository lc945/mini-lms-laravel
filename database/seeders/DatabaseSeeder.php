<?php

namespace Database\Seeders;

use App\Models\Chapitre;
use App\Models\Formation;
use App\Models\Note;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use App\Models\SousChapitre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Comptes de test
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@lms.fr',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $apprenant = User::create([
            'name' => 'Jean Dupont',
            'email' => 'apprenant@lms.fr',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
        ]);

        // Formation
        $formation = Formation::create([
            'nom' => 'Anglais — Verbes Irréguliers',
            'description' => 'Maîtrisez les verbes irréguliers essentiels en anglais.',
            'niveau' => 'Débutant',
            'duree' => 3,
        ]);

        // Assigner l'apprenant à la formation
        $apprenant->update(['formation_id' => $formation->id]);

        // Chapitre 1
        $chapitre1 = Chapitre::create([
            'titre' => 'Les verbes irréguliers',
            'description' => 'Introduction et liste des verbes irréguliers courants.',
            'formation_id' => $formation->id,
            'ordre' => 1,
        ]);

        // Sous-chapitre 1
        $sc1 = SousChapitre::create([
            'titre' => 'Définition et importance',
            'contenu' => 'Les verbes irréguliers sont des verbes dont la conjugaison ne suit pas les règles habituelles. Contrairement aux verbes réguliers qui ajoutent simplement "-ed" au passé, les verbes irréguliers changent complètement de forme. Ils sont très fréquents en anglais et indispensables à maîtriser.',
            'chapitre_id' => $chapitre1->id,
            'ordre' => 1,
        ]);

        // Sous-chapitre 2
        $sc2 = SousChapitre::create([
            'titre' => '10 verbes indispensables',
            'contenu' => "Voici les 10 verbes irréguliers les plus utilisés :\n\n" .
                "- Go → went → gone (aller)\n" .
                "- Come → came → come (venir)\n" .
                "- See → saw → seen (voir)\n" .
                "- Have → had → had (avoir)\n" .
                "- Do → did → done (faire)\n" .
                "- Make → made → made (faire/créer)\n" .
                "- Get → got → got (obtenir)\n" .
                "- Take → took → taken (prendre)\n" .
                "- Know → knew → known (savoir)\n" .
                "- Think → thought → thought (penser)",
            'chapitre_id' => $chapitre1->id,
            'ordre' => 2,
        ]);

        // Sous-chapitre 3
        $sc3 = SousChapitre::create([
            'titre' => 'Méthode de mémorisation',
            'contenu' => 'Pour mémoriser les verbes irréguliers efficacement : 1) Apprenez-les par groupes de formes similaires. 2) Pratiquez avec des phrases complètes. 3) Utilisez des fiches de révision (flashcards). 4) Répétez régulièrement en contexte.',
            'chapitre_id' => $chapitre1->id,
            'ordre' => 3,
        ]);

        // Quiz sur sc2
        $quiz = Quiz::create([
            'titre' => 'Quiz — 10 verbes indispensables',
            'sous_chapitre_id' => $sc2->id,
        ]);

        // Questions
        $questions = [
            ['Quel est le prétérit de GO ?', ['goed', 'went', 'gone'], 1],
            ['Quel est le participe passé de SEE ?', ['saw', 'seed', 'seen'], 2],
            ['Quel est le prétérit de COME ?', ['comed', 'came', 'come'], 1],
            ['Quel est le prétérit de MAKE ?', ['maked', 'moke', 'made'], 2],
            ['Quel est le participe passé de TAKE ?', ['took', 'taken', 'taked'], 1],
        ];

        foreach ($questions as [$texte, $reponses, $bonneIdx]) {
            $q = Question::create(['question' => $texte, 'quiz_id' => $quiz->id]);
            foreach ($reponses as $i => $r) {
                Reponse::create([
                    'texte' => $r,
                    'est_correcte' => ($i === $bonneIdx),
                    'question_id' => $q->id,
                ]);
            }
        }

        // Note de démo
        Note::create([
            'user_id' => $apprenant->id,
            'matiere' => 'Anglais — Verbes Irréguliers',
            'note' => 16.50,
        ]);
    }
}
