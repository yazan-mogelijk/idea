<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SessionController
{
    public function create(): View
    {
       return view('auth.login');
    }

    public function store(Request $request): RedirectResponse|Redirector
    {
        $attributes = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', Password::defaults()],
        ]);

        if (!Auth::attempt($attributes)) {

            return back()
                ->withErrors(['password' => 'The provided credentials do not match our records.'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended()->with('success', 'You have successfully logged in.');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();

        return redirect('/');
    }
}
