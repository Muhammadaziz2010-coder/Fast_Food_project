<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        /**
         * @var $user User
         */
        $user = User::where('username', $credentials['username'])->first();


        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }



        // Create new token
        $token = $user->createToken('auth-token')->plainTextToken;

        $expiresAt = null;


        if ($expiration = config('sanctum.expiration')) {
            $expiresAt = Carbon::now()->addMinutes(( $expiration))->toDateTimeString();
        }

        return $this->jsonResponse([
            'ok' => true,
            'user' => $user->only(['id','name','username']),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt
        ]);
    }

    public function me()
    {
        return ['ok' => true] + auth('api')->user()->only(['id','name','username']);
    }

    public function logout()
    {
        $user = auth('api')->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return ['message' => 'Successfully logged out'];
    }
}
