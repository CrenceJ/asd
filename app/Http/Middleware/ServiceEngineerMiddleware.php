<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
class ServiceEngineerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user() && $request->user()->type != 'service engineer'){
            return new Response(view('client_module.unauthorized') ->with('role', 'service engineer'));
        }
        return $next($request);
    }
}
