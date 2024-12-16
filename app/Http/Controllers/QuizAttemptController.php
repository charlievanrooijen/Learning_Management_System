<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizAttemptController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        $quizContent = json_decode($quiz->content, true);
        $answers = $request->input('answers', []);
        $score = 0;
    
        foreach ($quizContent as $index => $question) {
            $correctAnswers = collect($question['choices'])->filter(fn($c) => $c['is_correct'])->pluck('text')->toArray();
            $userAnswers = $answers[$index] ?? [];
    
            if ($correctAnswers === $userAnswers) {
                $score++;
            }
        }
    
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
        ]);
    
        return redirect()->route('quiz-attempt.review', $attempt->id);
    }

    public function index()
    {
        return Inertia::render('Dashboard', [
            'user' => Auth::user(),
            'quizzes' => Quiz::all(),
            'recentAttempts' => QuizAttempt::with('quiz')
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function review(QuizAttempt $attempt)
    {
        if (Auth::id() !== $attempt->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $quiz = $attempt->quiz;
        $quizContent = json_decode($quiz->content, true);

        $userAnswers = json_decode($attempt->answers, true);

        $feedback = [];
        foreach ($quizContent as $index => $question) {
            $correctAnswers = collect($question['choices'])->filter(fn($c) => $c['is_correct'])->pluck('text')->toArray();
            $userResponse = $userAnswers[$index] ?? [];

            $feedback[] = [
                'question' => $question['question'],
                'choices' => $question['choices'],
                'user_answers' => $userResponse,
                'correct_answers' => $correctAnswers,
                'is_correct' => $correctAnswers === $userResponse,
            ];
        }

        return Inertia::render('QuizAttempts/Review', [
            'quiz' => $quiz,
            'feedback' => $feedback,
            'score' => $attempt->score,
        ]);
    }
}
