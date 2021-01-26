<?php

namespace App\Http\Requests;

use App\Helpers\ApiHelpers;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    /**
     * Each resource request should define this property
     * @var $resource string
     */
    protected $resource;

    /**
     * This method is used for handling the parameters validation errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbiddenResponse()
    {
        return ApiHelpers::ApiResponse(403, 'Whoops!', null);
    }

    /**
     * This method is used for handling the parameters validation errors
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return ApiHelpers::ApiResponse(409, 'Whoops!', $errors);
    }

    /**
     * @param $resource_class
     * @param $record_id
     * @return mixed
     */
    protected function findRecordInRequest($resource_class, $record_id)
    {
        return call_user_func_array([$resource_class, "findOrFail"], [$record_id]);
    }
}
