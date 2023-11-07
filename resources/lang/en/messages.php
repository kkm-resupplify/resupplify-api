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
        'warehouseDataNotAccessible' => 'You can\'t access this warehouse data'
    ],

    'loginMessages' => [
        'validationError' => 'Error in login data validation',

        'noUserFound' => 'We haven\'t found a user with this email address',
        'wrongPassword' => 'You have provided wrong login details',
    ],

    'registerMessages' => [
        'validationError' =>
            'The data you provided for company registration is invalid',
        'userCreated' => 'User created successfully',
    ],

    'company' => [
        'validationError' => 'Error in company data validation',
    ],

    'userDetailsRequest' => [
        'validationError' =>
            'The data you\'ve provided for user details is invalid',
        'success' => 'Successfully updated user details',
    ],
];
