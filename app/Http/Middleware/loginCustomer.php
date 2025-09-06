<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class loginCustomer
{
    /**
     * Handle an incoming request.
     *
//     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('customer_id')) {
            session(['url.intended' => url()->full()]);
            return redirect()->route('customers.login');
        }

        return $next($request);
    }
}
