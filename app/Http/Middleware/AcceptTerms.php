<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptTerms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('bye');
        if (
            !$request->session()->has('terms_accepted') &&
            !($request->route()->uri() === 'accept-terms') &&
            !($request->route()->uri() === 'password')
        ) {
            return redirect('/accept-terms');
        }

        return $next($request);
    }
}
