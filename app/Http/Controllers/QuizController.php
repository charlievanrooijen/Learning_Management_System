<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'Teacher') {
            abort(403, 'Unauthorized action.');
        }

        return inertia('Quizzes/Create');
    }


    public function edit(Quiz $quiz)
    {
        if (Auth::id() !== $quiz->author_id && Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }
        
        return Inertia::render('Quizzes/Edit', [
            'quiz' => $quiz,
        ]);
    }
    

    public function update(Request $request, Quiz $quiz)
    {
        if (Auth::id() !== $quiz->author_id && Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:public,private',
            'content' => 'required|json',
        ]);

        $quiz->update($validated);

        return redirect()->route('dashboard')->with('success', 'Quiz updated successfully.');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Teacher') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:public,private',
            'content' => 'required|json',
        ]);

        Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'content' => $request->content,
            'author_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Quiz created successfully.');
    }


    public function index()
    {
        $quizzes = Quiz::where('status', 'public')->take(5)->get();

        return Inertia::render('Dashboard', [
            'user' => Auth::user(),
            'quizzes' => $quizzes,
        ]);
    }
}
