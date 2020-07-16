<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class UserMiddleware
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
        if ($request->user() && $request->user()->type != 2) {
           // echo "inside";
            //return view('unauthorised');
            return Response::view('unauthorised', [ 'role' => 'Admin' ]);
        }
        return $next($request);
    }
}
