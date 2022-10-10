<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('admin_state')) {
            return redirect('login');
        }

        View::share([
            '_tabs' => [
                ['name' => '仪表盘', 'value' => 'dashboard', 'is_active' => $request->routeIs('dashboard*')],
                ['name' => '相册', 'value' => 'albums.index', 'is_active' => $request->routeIs('albums*')],
            ],
        ]);

        return $next($request);
    }
}
