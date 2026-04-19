<?php

namespace App\Http\Controllers;

use App\Models\TypingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypingTestController extends Controller
{
    public function index()
    {
        return view('typing');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'wpm' => 'required|numeric|min:0',
            'accuracy' => 'required|numeric|min:0|max:100',
            'duration' => 'required|numeric|min:1',
            'correct_chars' => 'required|integer|min:0',
            'total_chars' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $result = Auth::user()->typingResults()->create($data);

        return response()->json(['success' => true, 'result' => $result]);
    }

    public function stats()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $results = Auth::user()->typingResults;

        return response()->json([
            'total_tests' => $results->count(),
            'avg_wpm' => round($results->avg('wpm'), 2),
            'avg_accuracy' => round($results->avg('accuracy'), 2),
            'best_wpm' => $results->max('wpm'),
            'total_time' => $results->sum('duration'),
            'recent' => $results->sortByDesc('created_at')->take(5)->values(),
        ]);
    }
}
