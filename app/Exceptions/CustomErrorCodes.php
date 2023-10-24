<?php

namespace App\Exceptions;

class CustomErrorCodes
{
    public const UNAUTHORIZED = 'general-0001';
    public const VALIDATION_FAILED = 'general-0002';
    public const LOGIN_FAILED = 'general-0003';
    public const REGISTER_FAILED = 'general-0004';
    public const LOGOUT_FAILED = 'general-0005';
    public const USER_ALREADY_EXISTS = 'general-0006';
    public const USER_DETAILS_ALREADY_EXISTS = 'general-0007';
    public const USER_ALREADY_HAVE_COMPANY = 'general-0008';

    public const COMPANY_NAME_TAKEN = 'company-0001';
    public const COMPANY_NOT_FOUND = 'company-0002';
}
