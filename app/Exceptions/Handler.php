<?php

namespace App\Exceptions;

use App\Exceptions\Company\CompanyNotFoundException;
use App\Exceptions\Filter\FilterNotAllowedException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductOfferNotFoundException;
use App\Exceptions\Product\ProductTagNotFoundException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\Warehouse\WarehouseNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
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
        if ($exception instanceof ModelNotFoundException) {
            switch ($exception->getModel()) {
                case 'App\Models\User\User':
                    throw new UserNotFoundException();
                    break;
                case 'App\Models\Company\Company':
                    throw new CompanyNotFoundException();
                    break;
                case 'App\Models\Warehouse\Warehouse':
                    throw new WarehouseNotFoundException();
                    break;
                case 'App\Models\Product\Product':
                    throw new ProductNotFoundException();
                    break;
                case 'App\Models\Product\ProductTag':
                    throw new ProductTagNotFoundException();
                    break;
                case 'App\Models\Product\ProductOffer':
                    throw new ProductOfferNotFoundException();
                    break;
                default:
                    break;
            }
        }
        if($exception instanceof InvalidFilterQuery)
        {
            throw new FilterNotAllowedException();
        }
        return parent::render($request, $exception);
    }

}
