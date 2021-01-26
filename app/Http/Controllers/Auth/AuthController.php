<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\{LoginRequest, ResetPassword,
ForgetPassword, RegisterRequest};
use App\Repositories\AuthRepository;

class AuthController extends ApiController
{
    /**
     * @var public $auth
     */

    public $auth;

    /**
     * Auth constructor.
     */
    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
        $this->middleware('jwt', ['only' => ['refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->auth->login($request->all());
    }

    /**
     * Register User with JWTauth
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function register(RegisterRequest $request)
     {
        $user = $this->auth->register($request->all());

        return $this->ApiResponse(201, 'Te has registrado exitosamente.', $user);
     }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->ApiResponse(200, 'Successfully logged out', null);
    }

    public function forget(ForgetPassword $request)
    {
        $this->SendEmailForget($request->email);
        return $this->ApiResponse(200, 'An email has been sent to reset your password', true);
    }

    public function resetPassword(ResetPassword $request)
    {
        $status = $this->ValidateToken($request->token);

        if ($status['response'] != true)
        {
            return $this->ApiResponse(400, 'The token has expired, please request a new one', null);
        }

       return $this->RestartPass($status['data'], request('password'));
    }
}
