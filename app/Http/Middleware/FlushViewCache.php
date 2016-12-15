<?php

namespace App\Http\Middleware;

use Cache;

class FlushViewCache
{

    public function handle($request, $next)
    {
        if (app()->environment() == 'local') {
            //clear the view specific cache
            Cache::tags('views')->flush();
        }

        return $next($request);
    }
}