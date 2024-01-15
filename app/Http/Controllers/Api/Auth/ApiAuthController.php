<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Traits\ApiResponser;

class ApiAuthController extends Controller
{
    use ApiResponser;

    public function register(UserRegisterRequest $request)
    {
        $payload = $request->all();
        $payload['password'] = Hash::make($payload['password']);

        $user = User::create($payload);
        $token = $user->createToken($payload['token_name'] ?? 'default_token');

        return $this->successResponse([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 'User created!', 201);
    }

    public function login(UserLoginRequest $request)
    {
        $payload = $request->all();

        if (!Auth::attempt($payload)) {
            return $this->errorResponse('The provided credentials are incorrect.', 401);
        }

        $user = auth()->user();

        $token = getNewToken($request);

        return $this->successResponse([
            'token' => $token,
            'user' => $user,
        ], 'User logged in!');
    }

    public function logout(Request $request, PersonalAccessToken $personalAccessToken)
    {
        $requestToken = $request->header('authorization');
        $token = $personalAccessToken->findToken(str_replace('Bearer ', '', $requestToken));

        $token->delete();
        return $this->successResponse([], 'Tokens Revoked');
    }

    public function currentUser()
    {
        return $this->successResponse(auth()->user());
    }
}
