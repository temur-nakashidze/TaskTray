<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, URL, or default to English
        $locale = session('locale', config('app.locale', 'en'));

        // Set the application locale
        app()->setLocale($locale);

        return $next($request);
    }
}
