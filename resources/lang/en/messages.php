<?php

return [
  "exception" => [
    'failedLogin' => 'Failed to login',
    'failedRegister' => 'Failed to register',
    'userAlreadyExists' => 'User with this email address already exists',
    'validationFailed' => 'Field validation failed',
    'companyNameTaken' => 'Company with this name is already registered',
    'unauthorized' => 'You are unauthorized to make this request',
    'roleNotFound' => 'Role not found',
    'userDetailsExists' => 'UserDetails already exists',
    'companyNotFound' => 'Company not found',
    'userAlreadyHaveCompany' => 'User already have a company',
  ],
  "loginMessages" =>
  [
    'validationError' => 'Error in login data validation',
    'authControllerError' =>'Something went wrong in AuthController.login',
    'noUserFound' =>'We havent found a user with this email address',
    'wrongPassword' =>'You have provided wrong password for this email address',
    'userLoginSuccess' => 'You have successful login',
    'userLogout' => 'User logged out',
  ],
  "registerMessages" =>
  [
    'validationError' => 'Error in register data validation',
    'authControllerError' =>'Something went wrong in AuthController.register',
    'userCreated' => 'User created successfully',
  ],
  "company" =>
  [
    'validationError' => 'Error in company data validation',
  ],
  "userDetailsRequest" =>
  [
    'validationError' => 'Error in user details request',
    'success' => 'Successfully updated user details',
  ],
];
