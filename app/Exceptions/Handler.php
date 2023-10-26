<?php

namespace App\Exceptions;

use App\Exceptions\Company\CompanyNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\InvalidOrderException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Client\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e)
        {

        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $exception->getModel() === 'App\Models\Company\Company') {
            throw new CompanyNotFoundException();
        }

        return parent::render($request, $exception);
    }

}
