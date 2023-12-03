<?php

namespace App\Services;

use App\Helpers\PaginationTrait;
use App\Helpers\ThrowExceptionTrait;

abstract class BasicService
{
    use ThrowExceptionTrait, PaginationTrait;

    public function __construct()
    {
    }
}
