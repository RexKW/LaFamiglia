<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index()
    {
        $quizzes = Quiz::where('user_id', auth()->id())
        ->withCount('flashcards')
        ->get();

        return view('quiz.index', compact('quizzes'));
    }
    public function review($quizId)
    {
        $quiz = Quiz::with('flashcards')->findOrFail($quizId);

        return view('quiz.review', compact('quiz'));
    }

    public function start($quizId)
    {
        $quiz = Quiz::with('flashcards')->findOrFail($quizId);

        if ($quiz->flashcards->isEmpty()) {
            return back()->with('error', 'No flashcards available for this quiz.');
        }

        return view('quiz.question', [
            'quiz' => $quiz,
            'currentQuestion' => 0,
            'questions' => $quiz->flashcards,
        ]);
    }

    public function destroy($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $quiz->flashcards()->delete();

        $quiz->delete();

        return view('quiz.index')->with('success', 'Quiz deleted successfully.');
    }


    public function checkAnswer(Request $request, $quizId)
    {
        $quiz = Quiz::with('flashcards')->findOrFail($quizId);
        $flashcards = $quiz->flashcards;

        $currentIndex = (int) $request->input('current_index', 0);
        $answer = $request->input('answer');

        if ($currentIndex < 0 || $currentIndex >= count($flashcards)) {
            return back()->with('error', 'Invalid question index.');
        }

        $flashcard = $flashcards[$currentIndex];
        $isCorrect = $answer === $flashcard->correct_answer;

        return response()->json([
            'isCorrect' => $isCorrect,
            'correctAnswer' => $flashcard->correct_answer,
            'explanation' => $flashcard->correct_answer,
        ]);
    }
}