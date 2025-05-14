<?php

namespace App\Http\Middleware;

use Closure;
 
use Illuminate\Http\Request;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Your existing middleware logic here
        
        return $next($request);
    }
}