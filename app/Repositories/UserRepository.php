<?php

namespace App\Repositories;

use App\Models\User;
use App\Helpers\ApiHelpers;
use App\Repositories\Repository;
use App\Models\Interfaces\UserInterface;
use App\Http\Resources\User\UserResource;

class UserRepository extends Repository implements UserInterface
{

    public function index($params)
    {
        $size = empty($params['paginate']) ? 1000 : $params['paginate'];
        $index = User::paginate((int)$size);
        
        return ApiHelpers::ApiResponse(200, 'Successfully completed', $index);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', New UserResource($user));
    }

    public function store($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'type_dni'   => $data['type_dni'],
            'dni'        => $data['dni'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password'])
        ]);
    
        return ApiHelpers::ApiResponse(201, 'Successfully completed', $user);
    }

    public function update($id, $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', New UserResource($user));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return ApiHelpers::ApiResponse(200, 'Successfully completed', null);
    }
}