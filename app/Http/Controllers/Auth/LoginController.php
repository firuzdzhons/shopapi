<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Tymon\JWTAuth\Exceptions\{
    JWTException
};
use Tymon\JWTAuth\JWTAuth;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function username()
    {
        return 'email';
    }

    public function login()
    {
        try {
            if (!$token = $this->auth->attempt(request()->only('email', 'password'))) {
                return response()->json(['message' => 'Логин или пароль введены неправильно.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Логин или пароль введены неправильно.'], $e->getStatusCode());
        }

        return response()->json([
            'token' => $token
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = request()->user();

        $data = [
            'id' => $user->id,
            'name' => $user->name
        ];

        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->auth->invalidate($this->auth->getToken());

        return response(['success' => 'logged out'], 200);
    }
}
