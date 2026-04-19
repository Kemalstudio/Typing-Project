<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! hash_equals(
            (string) $request->user()->getAuthPassword(),
            (string) bcrypt($request->password)
        )) {
            return back()->withErrors([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended(route('home', absolute: false));
    }
}
