<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthMiddleware extends Authenticate
{
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json(['message' => 'Unauthenticated.'], 401));

        // if ($request->expectsJson()) {
        //     abort(response()->json(['message' => 'Unauthenticated.'], 401));
        // }

        // redirect()->route('login');
    }
}
