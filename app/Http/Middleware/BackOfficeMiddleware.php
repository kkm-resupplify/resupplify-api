<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\UnauthorizedException;
use App\Models\User\Enums\UserTypeEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackOfficeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->type == UserTypeEnum::BACK_OFFICE()) {

            return $next($request);
        }

        throw new UnauthorizedException();
    }
}
