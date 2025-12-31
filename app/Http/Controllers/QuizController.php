<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{

    public function index(Request $request)
    {
        $query = Quiz::where('user_id', auth()->id())->withCount('flashcards');

        if ($request->has('sort') && $request->has('direction')) {
            $sort = $request->input('sort');
            $direction = $request->input('direction');

            if (in_array($sort, ['name', 'created_at']) && in_array($direction, ['asc', 'desc'])) {
                $query->orderBy($sort, $direction);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $quizzes = $query->get();

        return view('quiz.index', compact('quizzes'));
    }
    public function review($quizId)
    {
        $quiz = Quiz::with('flashcards')->find($quizId);
            if (!$quiz) {
                return view('components.errorPage', ['message' => 'Quiz not found.']);
            }

            if ($quiz->user_id !== auth()->id()) {
                return view('components.errorPage', ['message' => 'Unauthorized Access.']);
            }

            return view('quiz.review', compact('quiz'));
    }

    public function start($quizId)
    {
        $quiz = Quiz::with('flashcards')->find($quizId);

            if (!$quiz) {
                return view('components.errorPage', ['message' => 'Quiz not found.']);
            }

            if ($quiz->flashcards->isEmpty()) {
                return view('components.errorPage', ['message' => 'No flashcards available for this quiz.']);
            }

            if ($quiz->user_id !== auth()->id()) {
                return view('components.errorPage', ['message' => 'Unauthorized Access.']);
            }

        return view('quiz.question', [
            'quiz' => $quiz,
            'currentQuestion' => 0,
            'questions' => $quiz->flashcards,
        ]);
    }

    // Public shareable review via token
    public function publicReview($token)
    {
        $quiz = Quiz::with('flashcards')->where('share_token', $token)->first();
        if (!$quiz) {
            return view('components.errorPage', ['message' => 'Quiz not found or not shared.']);
        }

        return view('quiz.review', compact('quiz'));
    }

    // Public shareable start via token
    public function publicStart($token)
    {
        $quiz = Quiz::with('flashcards')->where('share_token', $token)->first();
        if (!$quiz) {
            return view('components.errorPage', ['message' => 'Quiz not found or not shared.']);
        }

        if ($quiz->flashcards->isEmpty()) {
            return view('components.errorPage', ['message' => 'No flashcards available for this quiz.']);
        }

        return view('quiz.question', [
            'quiz' => $quiz,
            'currentQuestion' => 0,
            'questions' => $quiz->flashcards,
        ]);
    }

    // Create or return existing share token (owner only)
    public function share($quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return back()->with('error', 'Quiz not found.');
        }

        if ($quiz->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $token = $quiz->ensureShareToken();
        $link = url('/s/' . $token . '/start');

        return back()->with('success', 'Share link created: ' . $link);
    }

    public function destroy($quizId)
    {
        $quiz = Quiz::find($quizId);

        if (!$quiz) {
            return view('components.errorPage', ['message' => 'Quiz not found.']);
        }

        $quiz->flashcards()->delete();

        $quiz->delete();

        return redirect()->route('home')->with('success', 'Quiz deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $quiz = Quiz::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $quiz->update(['name' => $request->name]);

        return back()->with('success', 'Quiz renamed successfully.');
    }



    public function checkAnswer(Request $request, $quizId)
    {
        $quiz = Quiz::with('flashcards')->find($quizId);
        if (!$quiz) {
            return response()->json(['error' => 'Quiz not found.'], 404);
        }
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