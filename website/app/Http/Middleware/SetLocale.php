<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = $request->headers->all();

        $languages = collect($headers["Accept-Language"]
            ?? config('themoviedb.set_language')
            ?? ['en'])
            ->first();
        $language = explode(',', explode(';', $languages)[0])[0];
        $language = explode('-', $language)[0];

        if (isset($language)) {
            app()->setLocale(strtolower($language));
        } else if (request('change_language')) {
            session()->put('language', request('change_language'));
            $language = request('change_language');
        } elseif (session('language')) {
            $language = session('language');
        } elseif (config('panel.primary_language')) {
            $language = config('panel.primary_language');
        }

        Carbon::setLocale(strtolower($language));

        $country = collect($headers["accept-country"]
            ?? request()->headers->all()['cf-ipcountry'][0]
            ?? ['US'])
            ->first();

        session(['country' => $country]);

        return $next($request);
    }
}
