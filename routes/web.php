<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('apprenants.dashboard');
    }
    return redirect()->route('login');
});

// Routes admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'admin'])->name('dashboard');

    Route::resource('formations', \App\Http\Controllers\FormationController::class);
    Route::resource('chapitres', \App\Http\Controllers\ChapitreController::class);
    Route::resource('sous-chapitres', \App\Http\Controllers\SousChapitreController::class);
    Route::resource('quiz', \App\Http\Controllers\QuizController::class);
    Route::resource('notes', \App\Http\Controllers\NoteController::class);
    Route::resource('apprenants', \App\Http\Controllers\AdminApprenantController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    Route::post('quiz/{quiz}/questions', [\App\Http\Controllers\QuestionController::class, 'store'])->name('questions.store');
    Route::delete('questions/{question}', [\App\Http\Controllers\QuestionController::class, 'destroy'])->name('questions.destroy');

    Route::post('generate-content', [\App\Http\Controllers\ContentGeneratorController::class, 'generate'])->name('generate.content');

    Route::get('ai/generate', [\App\Http\Controllers\AiCourseGeneratorController::class, 'index'])->name('ai.generate');
    Route::post('ai/generate', [\App\Http\Controllers\AiCourseGeneratorController::class, 'generate'])->name('ai.generate');
});

// Routes apprenant
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'apprenant'])->name('apprenants.dashboard');
    Route::get('/mes-formations', [\App\Http\Controllers\ApprenantController::class, 'index'])->name('apprenants.formations');
    Route::get('/mes-formations/{formation}', [\App\Http\Controllers\ApprenantController::class, 'show'])->name('apprenants.formations.show');
    Route::get('/sous-chapitre/{sousChapitre}', [\App\Http\Controllers\ApprenantController::class, 'showSousChapitre'])->name('apprenants.souschapitres.show');
    Route::get('/quiz/{quiz}/passer', [\App\Http\Controllers\QuizController::class, 'passer'])->name('quiz.passer');
    Route::post('/quiz/{quiz}/soumettre', [\App\Http\Controllers\QuizController::class, 'soumettre'])->name('quiz.soumettre');
    Route::get('/mes-notes', [\App\Http\Controllers\NoteController::class, 'mesNotes'])->name('notes.mes-notes');
});

require __DIR__.'/auth.php';
