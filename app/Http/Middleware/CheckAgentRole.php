<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAgentRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // تحقق من دور المستخدم وإذا كان ليس لديه دور الوكيل (Agent)، فعدل هنا
        if ($request->user() && $request->user()->role !== 'agent') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
