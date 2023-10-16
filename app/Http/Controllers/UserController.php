<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailsRequest;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function editUserDetails(UserDetailsRequest $request)
    {
        $userDetails = UserDetails::where(['user_id' => $this->user->id])->first();
        if (!$userDetails) {
            return response()->json(['error' => [
                'code' => 'gen-0011',
                'message' =>  __("messages.userDetailsRequest.validationError"),
                'data' => 'No user details found',
            ]], 422);
        }
        $userDetails->first_name = $request->input('first_name');
        $userDetails->last_name = $request->input('last_name');
        $userDetails->phone_number = $request->input('phone_number');
        $userDetails->birth_date = $request->input('birth_date');
        $userDetails->sex = $request->input('sex');
        $userDetails->update();
        return response()->json(
            [
                'message' =>  __("messages.userDetailsRequest.success"),
                'data' => $userDetails,
            ],
            200
        );
    }
}
