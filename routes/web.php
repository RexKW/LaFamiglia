<?php

use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('flashcardForm');
});

Route::post('/generate-flashcards', [FlashcardController::class, 'generateFlashcards'])->name('generate.flashcards');
Route::get('/quiz/{quiz}/review', [QuizController::class, 'review'])->name('quiz.review');
Route::get('/quiz/{quiz}/start', [QuizController::class, 'start'])->name('quiz.start');
Route::post('/quiz/{quiz}/check-answer', [QuizController::class, 'checkAnswer'])->name('quiz.check.answer');

