<?php
namespace App\Helpers;

trait ThrowExceptionTrait
{
    protected static function throw($exception): void
    {
        throw $exception;
    }
}
