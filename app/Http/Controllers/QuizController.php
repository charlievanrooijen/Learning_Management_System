<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'Teacher') {
            abort(403, 'Unauthorized action.');
        }

        return inertia('Quizzes/Create');
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
}
