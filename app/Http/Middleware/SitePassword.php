<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SitePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->session());
        if (
            !$request->session()->has('site_access_granted') &&
            !($request->route()->uri === 'password')
        ) {
            return redirect('/password');
        }

        // dd('hi');

        return $next($request);
    }
}
