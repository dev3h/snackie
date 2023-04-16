<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = session()->get('locale');
        if (empty($locale)) {
            $locale = $request->cookie('locale');
        }
        $available_locales = config('app.locales', []);
        if (!in_array($locale, $available_locales)) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale(session()->get('locale'));
        cookie('locale', $locale, time() + (86400 * 30));


        return $next($request);
    }
}
