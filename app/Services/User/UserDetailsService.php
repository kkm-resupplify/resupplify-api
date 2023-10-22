<?php

namespace App\Services\User;

use App\Exceptions\General\ValidationFailedException;
use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Http\Dto\User\UserDetailsDto;
use App\Models\User\User;
use App\Models\User\UserDetails;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\FailedLoginException;
use App\Exceptions\User\UserDetailsAlreadyExistsException;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use App\Resources\User\UserDetailsResource;

class UserDetailsService extends BasicService
{
    public function creatUserData(UserDetailsDto $request)
    {
        $user = Auth::user();

        if (UserDetails::where('user_id', $user->id)->exists()) {
            throw new UserDetailsAlreadyExistsException();
        }

        $userDetails = UserDetails::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'phone_number' => $request->phoneNumber,
            'birth_date' => $request->birthDate,
            'sex' => $request->sex,
            'user_id' => $user->id,
        ]);

        return new UserDetailsResource($userDetails);
    }

    public function editUserData(UserDetailsDto $request)
    {
        $user = Auth::user();
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        
        if (!isset($userDetails)) {
            throw new ValidationFailedException();
        }

        $userDetails->first_name = $request->firstName;
        $userDetails->last_name = $request->lastName;
        $userDetails->phone_number = $request->phoneNumber;
        $userDetails->birth_date = $request->birthDate;
        $userDetails->sex = $request->sex;
        $userDetails->save();
        
        return new UserDetailsResource($userDetails);
    }
}
