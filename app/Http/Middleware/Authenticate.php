<?php

namespace App\Http\Middleware;

use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    use HandleJsonResponse;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson() && ! Auth::check()) {
            return route('unauth');
        }
    }
}
