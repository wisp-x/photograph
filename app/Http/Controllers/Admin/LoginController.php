<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $password = $request->post('password');

        if ($password && $password === config('app.password')) {
            $request->session()->put('admin_state', true);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'password' => '密码不正确',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->remove('admin_state');

        return redirect()->route('login');
    }
}
