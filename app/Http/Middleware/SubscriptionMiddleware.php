<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Subscription::subscriptionDays(auth()->user()->id)==0) {
            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = 'Sin suscripcion!';
            $responseArr['is_valid'] = 0;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
