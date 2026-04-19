<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wpm' => 'required|numeric|min:0',
            'accuracy' => 'required|numeric|min:0|max:100',
            'duration' => 'required|numeric|min:1',
            'correct_chars' => 'required|numeric|min:0',
            'total_chars' => 'required|numeric|min:1',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $result = Auth::user()->typingResults()->create([
            'wpm' => $validated['wpm'],
            'accuracy' => $validated['accuracy'],
            'duration' => $validated['duration'],
            'correct_chars' => $validated['correct_chars'],
            'total_chars' => $validated['total_chars'],
            'difficulty' => $validated['difficulty'],
        ]);

        return response()->json([
            'success' => true,
            'result' => $result
        ], 201);
    }

    public function index()
    {
        $results = Auth::user()->typingResults()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($results);
    }

    public function show($id)
    {
        $result = TypingResult::findOrFail($id);
        $this->authorize('view', $result);

        return response()->json($result);
    }

    public function stats()
    {
        $results = Auth::user()->typingResults;

        return response()->json([
            'total_tests' => $results->count(),
            'avg_wpm' => round($results->avg('wpm'), 2),
            'avg_accuracy' => round($results->avg('accuracy'), 2),
            'best_wpm' => $results->max('wpm'),
            'total_time' => $results->sum('duration'),
        ]);
    }
}
