<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (auth()->check() && $user->twoFactorEnabled()) {
            if ($user->twoFactorCodeExpired()) {
                $user->resetTwoFactorCode();

                auth()->logout();

                return redirect()->route('login')
                    ->withMessage('Your two factor code has expired. Please login again.');
            }
            if (!request()->is('verify-2fa*')) {
                return redirect()->route('verify-2fa.index');
            }
        }

        return $next($request);
    }
}
