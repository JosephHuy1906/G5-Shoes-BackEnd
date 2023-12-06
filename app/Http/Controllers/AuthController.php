<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }

    public function profile()
    {
        try {

            return response()->json(auth()->user());
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token Unauthorized'
            ], 500);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ], 200);
    }
    public function refresh()
    {
        $refreshToken  = request()->refresh_token;
        try {

            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decoded['user_id']);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $token = auth()->login($user);
            $refreshToken = $this->createRefreshToken();

            return  $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Refresh token in Invald'
            ], 500);
        }
    }
    private function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'message' => 'Login successfully',
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    private function createRefreshToken()
    {
        $data = [
            'user_id' => auth()->user()->id,
            'ramdo' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        $refreshToken = JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }
}
