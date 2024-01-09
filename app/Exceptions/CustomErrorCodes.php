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
    public const COMPANY_ALREADY_VERIFIED = 'company-0005';
    public const NEGATIVE_COMPANY_BALANCE = 'company-0006';

    public const WAREHOUSE_NOT_FOUND = 'warehouse-0001';
    public const WAREHOUSE_DATA_NOT_ACCESSIBLE = 'warehouse-0002';
    public const WAREHOUSE_PRODUCT_QUANTITY = 'warehouse-0003';

    public const PRODUCT_NOT_FOUND = 'product-0001';
    public const PRODUCT_EXISTS_IN_WAREHOUSE = 'product-0002';
    public const PRODUCT_ALREADY_VERIFIED = 'product-0003';
    public const PRODUCT_TAG_NOT_FOUND = 'product-0004';
    public const PRODUCT_TAG_DONT_BELONG_TO_THIS_COMPANY = 'product-0005';
    public const PRODUCT_TRANSLATION = 'product-0006';
    public const PRODUCT_OFFER_QUANTITY = 'product-0007';
    public const PRODUCT_OFFER_EXIST = 'product-0008';
    public const PRODUCT_OFFER_NOT_FOUND = 'product-0009';

    public const ORDER_NOT_FOUND = 'order-0001';
    public const ORDER_NOT_ENOUGH_BALANCE = 'order-0002';
    public const ORDER_NOT_ENOUGH_PRODUCTS = 'order-0003';
    public const ORDER_CANT_BUY_PRODUCT = 'order-0004';


    public const FILTER_NOT_ALLOWED = 'filter-0001';

    public const TRANSACTION_ERROR = 'transaction-0001';
}
