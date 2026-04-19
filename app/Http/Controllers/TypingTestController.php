<?php

namespace App\Http\Controllers;

use App\Models\TypingResult;
use Illuminate\Http\Request;

class TypingTestController extends Controller
{
    public function index()
    {
        return view('typing');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wpm' => 'required|integer|min:0',
            'accuracy' => 'required|numeric|min:0|max:100',
            'duration' => 'required|integer|min:0',
            'correct_chars' => 'required|integer|min:0',
            'total_chars' => 'required|integer|min:0',
        ]);

        TypingResult::create($data);

        return response()->json(['success' => true]);
    }
}
