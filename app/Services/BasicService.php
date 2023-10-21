<?php

namespace App\Services;

use App\Helpers\ThrowExceptionTrait;

abstract class BasicService
{
    use ThrowExceptionTrait;

    public function __construct()
    {
    }
}
