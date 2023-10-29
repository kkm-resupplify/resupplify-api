<?php

namespace App\Http\Middleware;

use App\Exceptions\Company\UserDoesNotHaveCompanyException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && !Auth::user()->company)
        {
            throw new UserDoesNotHaveCompanyException();
        }
        return $next($request);
    }
}
