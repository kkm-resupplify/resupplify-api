<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidPasswordException;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use App\Models\User;
use App\Models\UserDetails;

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
                $token = $user->createToken('user_token')->plainTextToken;

                return response()->json(
                    ['user' => $user, 'token' => $token],
                    200
                );
            } else {
                throw new InvalidPasswordException;
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'code' => 'gen-0003',
                        'message' => __("messages.loginNoUserFound"),
                        'data' => $e->getMessage(),
                    ]
                ],
                401
            );
        } catch (InvalidPasswordException $e) { {
                return response()->json(
                    [
                        'error' => [
                            'code' => 'gen-0003',
                            'message' => __("messages.loginNoUserFound"),
                            'data' => $e->getMessage(),
                        ]
                    ],
                    401
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => [
                        'code' => 'gen-0002',
                        'message' => __("messages.loginAuthControllerError"),
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
            if ($user) {
                $user = UserDetails::create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                ]);
            }
            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 200);
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

    public function logout(LogoutRequest $request)
    {
        try {
            $user = User::findOrFail($request->input('user_id'));

            $user->tokens()->delete();

            return response()->json('User logged out!', 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout',
            ]);
        }
    }
}
