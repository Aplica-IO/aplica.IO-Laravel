<?php

namespace App\Http\Resources\Geolocation;

use App\Http\Resources\Geolocation\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Geolocation\StateResource;
use App\Http\Resources\Geolocation\CountryResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'location'    => $this->location,
            'street'      => $this->street,
            'zip_code'    => $this->zip_code,
            'country_id'  => CountryResource::make($this->country),
            'state_id'    => StateResource::make($this->state),
            'city_id'     => CityResource::make($this->city),
            'created_at'  => ($this->created_at)->format('Y-m-d h:m:s'),
            'updated_at'  => ($this->updated_at)->format('Y-m-d h:m:s')
        ];
    }
}
