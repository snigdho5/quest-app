<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    protected $redirectToUser = '/';
    protected $redirectToAdmin = 'admin/dashboard';

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch ($guard) {
                case 'admin':
                    return redirect($this->redirectToAdmin);
                    break;
                default:
                    return redirect($this->redirectToUser);
                    break;
            }

        }

        return $next($request);
    }
}
