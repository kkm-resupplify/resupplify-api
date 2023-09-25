<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidPasswordException;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use App\Models\User;
use App\Models\UserDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where(
                'email',
                '=',
                $request->input('email')
            )->firstOrFail();

            if (Hash::check($request->input('password'), $user->password)) {
                $user->tokens()->delete();
                $token = $user->createToken('user_token')->plainTextToken;

                return response()->json(
                    [
                        'message' => __("login_messages.userLoginSuccess"),
                        'data' =>
                        [
                            'token' => $token,
                            'user' => $user,
                        ],
                        'code' => 'gen-0006'
                    ],
                    200
                );
            } else {
                throw new InvalidPasswordException;
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'code' => 'gen-0002',
                        'message' => __("login_messages.noUserFound"),
                        'data' => $e->getMessage(),
                    ]
                ],
                401
            );
        } catch (InvalidPasswordException $e) {
            return response()->json(
                [
                    'error' => [
                        'code' => $e->getCode(),
                        'message' => __("login_messages.wrongPassword"),
                        'data' => $e->getMessage(),
                    ]
                ],
                401
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => [
                        'code' => 'gen-0004',
                        'message' => __("login_messages.authControllerError"),
                        'data' => $e->getMessage(),
                    ]
                ],
                401
            );
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $userDetails = UserDetails::create([
                'user_id' => $user->id,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),

            ]);

            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json(
                [
                    'message' => __("register_messages.userCreated"),
                    'data' =>
                    [
                        'token' => $token,
                        'user' => $user,
                        '$userDetails' => $userDetails
                    ],
                    'code' => 'gen-0005'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'message' =>
                    'Something went wrong in AuthController.register',
                ],
                401
            );
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(
                [
                    'message' => __("login_messages.userLogout"),
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout',
            ]);
        }
    }
}
