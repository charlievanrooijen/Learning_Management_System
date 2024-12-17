<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAttemptController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landingpage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])
        ->middleware(['auth', 'verified'])
        ->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])
        ->name('quizzes.update');

    Route::get('/quizzes/search', [QuizController::class, 'search'])->name('quizzes.search');

    Route::get('/quizzes/{quiz}/take', [QuizController::class, 'takeQuiz'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submitQuiz'])->name('quizzes.submit');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/quizzes/{quiz}/attempt', [QuizAttemptController::class, 'store'])->name('quiz-attempt.store');
    Route::get('/quiz-attempts/{attempt}/review', [QuizAttemptController::class, 'review'])->name('quiz-attempt.review');
});

Route::get('/dashboard', [QuizController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
