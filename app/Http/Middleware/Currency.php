<?php

namespace App\Http\Middleware;

use App\Models\ShopCurrency;
use Closure;
use Session;

class Currency
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
        ShopCurrency::setCode(session('currency') ?? sc_config('SITE_CURRENCY'));
        return $next($request);
    }
}
