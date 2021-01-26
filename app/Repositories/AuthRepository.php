<?php

namespace App\Repositories;

use JWTAuth;
use App\Models\User;
use App\Helpers\ApiHelpers;
use App\Models\Interfaces\AuthInterface;
use App\Repositories\Repository;

class AuthRepository extends Repository implements AuthInterface
{
    public function login($data)
    {
       $verify = $this->validate($data['email']);

       if ($verify['is_active'] != true){
            return ApiHelpers::ApiResponse(400, 'Whoops, Your user is disabled', null);
        }

        if (!$token = JWTAuth::attempt($data)) {
            return ApiHelpers::ApiResponse(400, 'Whoops, your credentials are invalid', null);
        }

        return $this->respondWithToken($token);
    }

    public function register($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'type_dni'   => $data['type_dni'],
            'dni'        => $data['dni'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
            'type_id'    => $data['type_id']
        ]);

        return $user;
    }

    public function validate($email)
    {
        return User::select('is_active')
            ->where('email', $email)->first();
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function respondWithToken($token)
    {
        return ApiHelpers::ApiResponse(200, 'Successfully completed', [
            'token' => $token,
            'refresh_ttl' => config('jwt.ttl'),
            'details' => auth()->user(),
        ]);
    }
}
