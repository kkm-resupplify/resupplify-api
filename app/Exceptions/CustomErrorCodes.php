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
    public const USER_INVITE_CODE_NOT_FOUND = 'general-0009';
    public const USER_INVITE_CODE_USED = 'general-0010';
    public const USER_NOT_FOUND = 'general-0011';
    public const USER_DOES_NOT_HAVE_COMPANY = 'general-0012';
    public const USER_IS_NOT_MEMBER_OF_THIS_COMPANY = 'general-0013';
    public const CANT_CREATE_USER_INVITATION = 'general-0014';
    public const CANT_CREATE_USER_INVITATION_ROLE = 'general-0015';
    public const WRONG_PERMISSIONS = 'general-0016';


    public const COMPANY_NAME_TAKEN = 'company-0001';
    public const COMPANY_NOT_FOUND = 'company-0002';
    public const CANT_DELETE_USER = 'company-0003';
    public const CANT_DELETE_YOURSELF = 'company-0004';

    public const WAREHOUSE_NOT_FOUND = 'warehouse-0001';
    public const WAREHOUSE_DATA_NOT_ACCESSIBLE = 'warehouse-0002';

    public const PRODUCT_NOT_FOUND = 'product-0001';
    public const PRODUCT_EXISTS_IN_WAREHOUSE = 'product-0002';
    public const PRODUCT_TAG_NOT_FOUND = 'product-0003';
    public const PRODUCT_TAG_DONT_BELONG_TO_THIS_COMPANY = 'product-0004';

    public const FILTER_NOT_ALLOWED = 'filter-0001';



}
