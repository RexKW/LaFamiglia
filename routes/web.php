<?php

use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('index');
    // return view('login');
    return redirect('/login');
});



Route::get('/login', function (){
    return view('login');
})->name('login');

Route::get('/register', function (){
    return view('register');
});

Route::post('/login', [UserController::class, 'login'])->name('loginUser');
Route::post('/register', [UserController::class, 'register'])->name('registerUser');

// Route::middleware([Middleware::class])->group(function () {
//     Route::get('/home', [QuizController::class, 'index'])->name('home');
// });

Route::middleware('auth')->group(function () {
    Route::get('/home', [QuizController::class, 'index'])->name('home');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/generate-flashcards', [FlashcardController::class, 'showGenerateForm'])->name('show.generate.form');
    Route::post('/generate-flashcards', [FlashcardController::class, 'generateFlashcards'])->name('generate.flashcards');
    Route::get('/quiz/{quiz}/review', [QuizController::class, 'review'])->name('quiz.review');
    Route::get('/quiz/{quiz}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{quiz}/check-answer', [QuizController::class, 'checkAnswer'])->name('quiz.check.answer');
    Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy');
    Route::post('/quiz/{quiz}/share', [QuizController::class, 'share'])->name('quiz.share');
    Route::get('/account', [UserController::class, 'account'])->name('account');
});

// Public shareable routes (no auth required)
Route::get('/s/{token}/review', [QuizController::class, 'publicReview'])->name('quiz.public.review');
Route::get('/s/{token}/start', [QuizController::class, 'publicStart'])->name('quiz.public.start');





