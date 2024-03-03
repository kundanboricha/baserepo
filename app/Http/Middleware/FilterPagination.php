<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilterPagination
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRequest = $request->all();
        unset($currentRequest['page']);
        unset($currentRequest['sortAs']);
        unset($currentRequest['orderBy']);

        if (!$request->filled('page')) {
            session()->forget('sessionRequest');
            return $next($request);
        }

        if (!empty(session('sessionRequest'))) {
            if (session('sessionRequest') != json_encode($currentRequest)) {
                $request->merge(['page' => 1]);
            }
        }
        session(['sessionRequest' => json_encode($currentRequest)]);

        return $next($request);
    }
}
