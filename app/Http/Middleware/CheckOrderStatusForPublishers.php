<?php

namespace App\Http\Middleware;

use App\Order;
use Closure;

class CheckOrderStatusForPublishers
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
        Order::updateStatusForPublisher();
        return $next($request);
    }
}
