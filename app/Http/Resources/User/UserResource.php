<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = empty($this->last_login) ? null : ($this->last_login)->format('Y-m-d h:m:s'); 

        return [
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'type_dni'    => $this->type_dni,
            'dni'         => $this->dni,
            'email'       => $this->email,
            'is_active'   => $this->is_active,
            'last_login'  => $date,
            'created_at'  => ($this->created_at)->format('Y-m-d h:m:s'),
            'updated_at'  => ($this->updated_at)->format('Y-m-d h:m:s')
        ];
    }
}