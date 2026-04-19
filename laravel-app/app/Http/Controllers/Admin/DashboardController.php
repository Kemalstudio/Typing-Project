<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TypingResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_tests' => TypingResult::count(),
            'avg_wpm' => round(TypingResult::avg('wpm'), 2),
            'avg_accuracy' => round(TypingResult::avg('accuracy'), 2),
        ];

        $recent_results = TypingResult::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_results'));
    }

    public function users()
    {
        $users = User::withCount('typingResults')
            ->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function results()
    {
        $results = TypingResult::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.results', compact('results'));
    }

    public function userResults($userId)
    {
        $user = User::with('typingResults')->findOrFail($userId);
        $results = $user->typingResults()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.user-results', compact('user', 'results'));
    }

    public function deleteResult($id)
    {
        $result = TypingResult::findOrFail($id);
        $result->delete();

        return redirect()->back()->with('success', 'Result deleted successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->typingResults()->delete();
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
