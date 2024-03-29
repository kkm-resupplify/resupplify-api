<?php

return [
    'exception' => [
        'failedLogin' => 'Failed to login',
        'failedRegister' => 'Failed to register an account',
        'userAlreadyExists' => 'User with this email address already exists',
        'validationFailed' => 'Field validation failed',
        'companyNameTaken' => 'Company with this name is already registered',
        'unauthorized' => 'You are unauthorized to make this request',
        'roleNotFound' => 'Role not found',
        'userDetailsExists' =>
            'User already has details set - use update method',
        'companyNotFound' => 'Company not found',
        'companyAlreadyVerified' => 'Company is already verified',
        'userAlreadyHaveCompany' => 'You already are a member of a company',
        'userInviteCodeNotFound' => 'This invitation token does not exist',
        'userInviteCodeUsed' => 'This invitation token has been used already',
        'userDoesNotHaveCompany' => 'You\'re not a member of any company',
        'userIsNotMemberOfThisCompany' =>
            'You\'re not a member of this company',
        'userNotFound' => 'User not found',
        'cantDeleteThisUser' =>
            'You cannot delete this member due to his or your permissions',
        'cantCreateUserInvitation' =>
            'You cannot create user invitation token due to your permissions',
        'cantCreateUserInvitationRole' =>
            'You cannot assign this role to this invitation',
        'cantDeleteYourself' => 'You cannot remove yourself from the company',
        'wrongPermissions' =>'You do not have the required permissions to perform this action','warehouseNotFound' => 'Warehouse not found',
        'productNotFound' => 'Product not found',
        'warehouseDataNotAccessible' => 'You can\'t access this warehouse data',
        'productExistsInWarehouse' => 'Product already exists in this warehouse',
        'filterNotAllowed' => 'Filter is not allowed',
        'productAlreadyVerified' => 'Product is already verified',
        'productTagNotFound' => 'Product tag not found',
        'productTagDontBelongToThisCompany' => 'This product tag does not belong to your company',
        'productTransaction' => 'You need to translate product name for all languages',
        'negativeCompanyBalanceException' => 'Your company balance will be negative, you can\'t perform this transaction',
        'wrongTransaction' => 'You can\'t perform this transaction',
        'productOfferQuantity' => 'Not enough quantity in warehouse',
        'productOfferNotFound' => 'Product offer not found',
        'productOfferExists' => 'Product offer already exists',
        'order' => [
            'balance' => 'Not enough money to buy this product',
            'productQuantity' => 'Not enough products in offer',
            'productOfferNotFound' => 'Product offer not found',
            'wrongTransaction' => 'You can\'t perform this transaction',
            'cantBuyCompanyProduct' => 'You can\'t buy your own products',
        ]
    ],
];
