<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
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
         return $next($request)
             ->header('Access-Control-Allow-Origin', '*') // Allow all origins, or specify the domain here
             ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS') // Allow specific methods
             ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-Custom-Header'); // Allow specific headers
     }
}
