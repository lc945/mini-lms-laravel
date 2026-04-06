# Mini LMS Pédagogique — Laravel 13

Plateforme de gestion de formations développée en Laravel dans le cadre d'un exercice de stage.
Elle permet à un administrateur de gérer des formations, chapitres, sous-chapitres, quiz et notes,
et à un apprenant de consulter les contenus et de passer des quiz.

---

## Stack technique

| Composant | Version |
|-----------|---------|
| PHP | 8.4 |
| Laravel | 13 |
| Base de données | SQLite (dev) / MySQL (prod) |
| CSS | Tailwind CSS (CDN) |
| Authentification | Laravel Breeze |
| Vues | Blade |

---

## Prérequis

- PHP >= 8.4
- Composer
- Node.js + npm
- SQLite (inclus avec PHP) ou MySQL

---

## Installation

```bash
# 1. Cloner le dépôt
git clone https://github.com/lc945/mini-lms-laravel.git
cd mini-lms-laravel

# 2. Installer les dépendances PHP
composer install --ignore-platform-reqs

# 3. Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Base de données (SQLite par défaut, rien à configurer)
php artisan migrate:fresh --seed

# 5. Assets front-end
npm install && npm run build

# 6. Lancer le serveur
php artisan serve
```

Ouvrir **http://127.0.0.1:8000**

### Configuration MySQL (optionnel)

Dans `.env`, remplacer les lignes SQLite par :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_lms
DB_USERNAME=root
DB_PASSWORD=
```

Puis relancer : `php artisan migrate:fresh --seed`

---

## Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@lms.fr | password |
| Apprenant | apprenant@lms.fr | password |

> Les comptes sont créés automatiquement par le seeder (`database/seeders/DatabaseSeeder.php`).

---

## Fonctionnalités

### Parcours Administrateur

- **Formations** — Créer, modifier, supprimer des formations (nom, niveau, durée, description)
- **Chapitres** — Organiser chaque formation en chapitres ordonnés
- **Sous-chapitres** — Ajouter du contenu pédagogique textuel à chaque chapitre (saisie manuelle ou collé depuis une IA)
- **Quiz** — Créer un quiz QCM par sous-chapitre, ajouter/supprimer des questions à choix multiple avec une bonne réponse
- **Notes** — Saisir et modifier les notes des apprenants (/20) par matière

### Parcours Apprenant

- **Mes formations** — Consulter toutes les formations disponibles
- **Contenu** — Naviguer dans les chapitres et lire les sous-chapitres
- **Quiz** — Passer un quiz et obtenir son score en temps réel (correct / total + pourcentage)
- **Mes notes** — Consulter ses notes avec appréciation et moyenne générale

### Authentification

- Inscription (rôle apprenant par défaut)
- Connexion avec redirection automatique selon le rôle
- Déconnexion
- Réinitialisation de mot de passe

---

## Modèle de données

```
users
  id, name, email, password, role (admin|apprenant)

formations
  id, nom, description, niveau, duree

chapitres
  id, titre, description, formation_id, ordre

sous_chapitres
  id, titre, contenu, chapitre_id, ordre

quiz
  id, titre, sous_chapitre_id

questions
  id, question, quiz_id

reponses
  id, texte, est_correcte (boolean), question_id

notes
  id, user_id, matiere, note (decimal)
```

**Relations :** Formation → Chapitres → Sous-chapitres → Quiz → Questions → Réponses

---

## Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                   # Breeze (login, register, etc.)
│   │   ├── ApprenantController.php # Parcours apprenant
│   │   ├── ChapitreController.php
│   │   ├── FormationController.php
│   │   ├── NoteController.php
│   │   ├── QuestionController.php  # Ajout/suppression de questions
│   │   ├── QuizController.php      # Quiz + passer/soumettre
│   │   └── SousChapitreController.php
│   └── Middleware/
│       └── AdminMiddleware.php     # Contrôle d'accès admin
├── Models/
│   ├── Chapitre.php
│   ├── Formation.php
│   ├── Note.php
│   ├── Question.php
│   ├── Quiz.php
│   ├── Reponse.php
│   ├── SousChapitre.php
│   └── User.php
database/
├── migrations/                     # 11 migrations
└── seeders/
    └── DatabaseSeeder.php          # Données de démo
resources/views/
├── admin/                          # Vues CRUD admin
│   ├── chapitres/
│   ├── formations/
│   ├── notes/
│   ├── quiz/
│   └── souschapitres/
├── apprenants/                     # Vues côté apprenant
│   ├── formations/
│   ├── notes/
│   ├── quiz/
│   └── souschapitres/
├── auth/                           # Vues Breeze
└── layouts/
    └── app.blade.php               # Layout principal
routes/
├── web.php                         # Routes LMS
└── auth.php                        # Routes Breeze
```

---

## Routes principales

### Admin (protégées par `auth` + `admin`)

| Méthode | URI | Action |
|---------|-----|--------|
| GET | /admin/formations | Liste des formations |
| GET | /admin/formations/create | Formulaire création |
| GET | /admin/chapitres | Liste des chapitres |
| GET | /admin/sous-chapitres | Liste des sous-chapitres |
| GET | /admin/quiz | Liste des quiz |
| GET | /admin/quiz/{id} | Gérer questions/réponses |
| POST | /admin/quiz/{id}/questions | Ajouter une question |
| GET | /admin/notes | Liste des notes |

### Apprenant (protégées par `auth`)

| Méthode | URI | Action |
|---------|-----|--------|
| GET | /mes-formations | Liste des formations |
| GET | /mes-formations/{id} | Détail formation + chapitres |
| GET | /sous-chapitre/{id} | Contenu + quiz associé |
| GET | /quiz/{id}/passer | Passer un quiz |
| POST | /quiz/{id}/soumettre | Soumettre et voir le score |
| GET | /mes-notes | Consulter ses notes |

---

## Contenu pédagogique IA

Le seeder intègre un exemple de contenu généré par IA sur le thème **« Les verbes irréguliers en anglais »** :

- 1 formation : *Anglais — Verbes Irréguliers* (niveau Débutant)
- 1 chapitre : *Les verbes irréguliers*
- 3 sous-chapitres : Définition, 10 verbes indispensables, Méthode de mémorisation
- 1 quiz de 5 questions QCM sur les formes irrégulières (go/went/gone, see/saw/seen…)
- 1 note de démonstration : 16.50/20

La zone de saisie des sous-chapitres accepte du texte collé directement depuis ChatGPT ou tout autre outil IA.

---

## Choix techniques

- **SQLite par défaut** — zéro configuration pour la démo, facilement remplaçable par MySQL
- **Tailwind CDN** — pas de compilation nécessaire pour les vues
- **Middleware AdminMiddleware** — séparation claire des rôles sans dépendance externe
- **Relations Eloquent** — cascade de suppression, eager loading pour éviter les N+1
- **Validation Laravel** — tous les formulaires sont validés côté serveur avec messages d'erreur
