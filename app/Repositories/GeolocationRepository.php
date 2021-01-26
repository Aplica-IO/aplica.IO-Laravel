<?php

namespace App\Repositories;

use App\Models\Address;
use App\Helpers\ApiHelpers;
use App\Repositories\Repository;
use App\Models\Interfaces\AddressInterface;
use App\Http\Resources\Geolocation\AddressResource;

class GeolocationRepository extends Repository implements AddressInterface
{

    public function index($params)
    {
        $size = empty($params['paginate']) ? 1000 : $params['paginate'];
        $index = Address::with('country', 'state', 'city')->paginate((int)$size);
        
        return ApiHelpers::ApiResponse(200, 'Successfully completed', $index);
    }

    public function show($id)
    {
        $location = Address::findOrFail($id);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', New AddressResource($location));
    }

    public function store($data)
    {
        $filter_resource = $this->removeNullables($data);
        $location = Address::create($filter_resource);

        return ApiHelpers::ApiResponse(201, 'Successfully completed', $location);
    }

    public function update($id, $data)
    {
        $location = Address::findOrFail($id);
        $location->update($data);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', New AddressResource($location));
    }

    public function destroy($id)
    {
        $location = Address::findOrFail($id);
        $location->delete();

        return ApiHelpers::ApiResponse(200, 'Successfully completed', null);
    }
}