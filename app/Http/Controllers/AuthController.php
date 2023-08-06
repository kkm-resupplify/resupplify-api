<?php
namespace App\Http\Controllers;

use App\Http\Requests\User\LogoutRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

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

            $user = User::where('email', '=', $request->input('email'))->firstOrFail();


            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('user_token')->plainTextToken;
                return response()->json([ 'user' => $user, 'token' => $token ], 200);
            }

            return response()->json([ 'error' => 'Something went wrong in login' ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.login'
            ], 401);
        }
    }
    public function register(RegisterRequest $request): array
    {
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            
            $token = $user->createToken('user_token')->plainTextToken;
            return response()->json([ 'user' => $user, 'token' => $token ], 200);

        } catch (\Exception $e) {
            return response()->array([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.register'
            ], 401);
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
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }
}