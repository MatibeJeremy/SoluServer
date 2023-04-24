<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogInController extends Controller
{

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Logs user in and provides an JSON access token
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'message' => $validator->messages()->first(),
                    'status' => 'Fail'
                ]
            ], 401);
        }

        // get authentication token
        $credentials = $request->only('email_address', 'password');
        $token = $this->guard()->attempt($credentials);

        // login successfully
        if($token){
            return $this->respondWithToken($token, auth()->user());
        }

        // invalid credentials response
        return response()->json([
            'error' => [
                'message' => 'Login failed. Invalid email or password',
                'status' => 'Fail'
            ]
        ], 401);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => new UserResource($user),
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ], 200);
    }



    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    public function guard()
    {
        return Auth::guard('');
    }
}