<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class AdminMiddleware
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
        if ($request->user() && $request->user()->type != 1) {
            return Response::view('unauthorised', [ 'role' => 'User' ]);
        }
        return $next($request);
    }
}
