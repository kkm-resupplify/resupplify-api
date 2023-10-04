<?php
namespace App\Helpers;

trait ThrowExceptionTrait
{
    protected function throw($exception): void
    {
        throw $exception;
    }
}
