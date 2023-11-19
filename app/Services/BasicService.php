<?php

namespace App\Services;

use App\Helpers\ThrowExceptionTrait;
use App\Helpers\PaginationTrait;
abstract class BasicService
{
    use ThrowExceptionTrait, PaginationTrait;

    public function __construct()
    {
    }
}
