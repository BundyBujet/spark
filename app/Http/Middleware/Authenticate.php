<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $route = $request->route();

        // Check if the route has 'admin' middleware assigned
        if ($this->hasMiddleware($route, 'admin')) {
            return route('get.admin.login');
        }


        // Check if the route has 'web' middleware assigned
        if ($this->hasMiddleware($route, 'web')) {
            return route('/');
        }

        return null; // Redirect to default route if no applicable middleware found
    }

    protected function hasMiddleware(Route $route, $middleware): bool
    {
        $gatheredMiddleware = $route->gatherMiddleware();

        return in_array($middleware, $gatheredMiddleware);
    }
}
