<?php

namespace App\Http\Resources\Residence;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Geolocation\AddressResource;

class ResidenceResource extends JsonResource
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
            'name'        => $this->name,
            'nif'         => $this->nif,
            'auditor_id'  => UserResource::make($this->auditor_id),
            'address_id'  => AddressResource::make($this->address_id),
            'created_at'  => ($this->created_at)->format('Y-m-d h:m:s'),
            'updated_at'  => ($this->updated_at)->format('Y-m-d h:m:s')
        ];
    }
}
