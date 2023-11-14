<?php

return [
    'exception' => [
        'failedLogin' => 'Nie udało się zalogować',
        'failedRegister' => 'Nie udało się zarejestrować konta',
        'userAlreadyExists' => 'Użytkownik o tym adresie e-mail już istnieje',
        'validationFailed' => 'Błąd walidacji pola',
        'companyNameTaken' => 'Firma o tej nazwie jest już zarejestrowana',
        'unauthorized' => 'Nie masz uprawnień do wykonania tego żądania',
        'roleNotFound' => 'Rola nie znaleziona',
        'userDetailsExists' =>
            'Użytkownik ma już ustawione szczegóły - użyj metody aktualizacji',
        'companyNotFound' => 'Nie znaleziono firmy',
        'companyAlreadyVerified' => 'Firma jest już zweryfikowana',
        'userAlreadyHaveCompany' => 'Jesteś już członkiem firmy',
        'userInviteCodeNotFound' => 'Ten token zaproszenia nie istnieje',
        'userInviteCodeUsed' => 'Ten token zaproszenia został już użyty',
        'userDoesNotHaveCompany' => 'Nie jesteś członkiem firmy',
        'userIsNotMemberOfThisCompany' => 'Nie jesteś członkiem tej firmy',
        'userNotFound' => 'Użytkownik nie znaleziony',
        'cantDeleteThisUser' =>
            'Nie możesz usunąć tego użytkownika ze względu na jego lub twoje uprawnienia',
        'cantCreateUserInvitation' =>
            'Nie możesz utworzyć tokena zaproszenia użytkownika ze względu na twoje uprawnienia',
        'cantCreateUserInvitationRole' =>
            'Nie możesz przypisać tej roli do tego zaproszenia',
        'cantDeleteYourself' => 'Nie możesz usunąć siebie z firmy',
        'wrongPermissions' =>
            'Nie masz wymaganych uprawnień do wykonania tej czynności',
    ],

    'loginMessages' => [
        'validationError' => 'Błąd walidacji danych logowania',
        'noUserFound' => 'Nie znaleźliśmy użytkownika o tym adresie e-mail',
        'wrongPassword' => 'Podałeś błędne dane logowania',
    ],

    'registerMessages' => [
        'validationError' =>
            'Dane, które podałeś do rejestracji firmy, są nieprawidłowe',
        'userCreated' => 'Użytkownik został pomyślnie utworzony',
    ],

    'company' => [
        'validationError' => 'Błąd walidacji danych firmy',
    ],

    'userDetailsRequest' => [
        'validationError' =>
            'Dane, które podałeś do szczegółów użytkownika, są nieprawidłowe',
        'success' => 'Pomyślnie zaktualizowano szczegóły użytkownika',
    ],
];
