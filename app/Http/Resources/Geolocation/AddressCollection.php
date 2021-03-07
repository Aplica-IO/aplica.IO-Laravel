<?php

namespace App\Http\Resources\Geolocation;

use App\Http\Resources\Geolocation\AddressResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'current_page'  => $this->currentPage(),
            'data'          => $this->collection,
            'per_page'      => $this->perPage(),
            'last_page'     => $this->lastPage(),
            'next_page_url' => $this->nextPageUrl(),
            'prev_page_url' => $this->previousPageUrl(),
            'total'         => $this->count(),
        ];
    }
}
