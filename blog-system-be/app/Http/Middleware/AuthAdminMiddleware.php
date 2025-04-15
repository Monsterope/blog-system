<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user() == null){
            return response()->json(["message" => "Unauthorzation."], HttpResponse::HTTP_UNAUTHORIZED);
        }
        if ($request->user()->role != "admin"){
            return response()->json(["message" => "Unauthorzation."], HttpResponse::HTTP_UNAUTHORIZED);
        }
        
        return $next($request);
    }
}
