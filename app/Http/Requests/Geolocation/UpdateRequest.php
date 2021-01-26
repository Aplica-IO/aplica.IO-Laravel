<?php

namespace App\Http\Requests\Geolocation;

use App\Http\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location'    => 'required',
            'street'      => 'required',
            'zip_code'    => 'sometimes',
            'lat'         => 'required|numeric',
            'long'        => 'required|numeric',
            'country_id'  => 'required|exists:countries,id', 
            'state_id'    => 'required|exists:states,id', 
            'city_id'     => 'required||exists:cities,id'
        ];
    }
}
