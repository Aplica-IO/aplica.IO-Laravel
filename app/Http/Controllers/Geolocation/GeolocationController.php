<?php

namespace App\Http\Controllers\Geolocation;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Geolocation\ShowRequest;
use App\Http\Requests\Geolocation\IndexRequest;
use App\Http\Requests\Geolocation\StoreRequest;
use App\Http\Requests\Geolocation\UpdateRequest;
use App\Http\Requests\Geolocation\DestroyRequest;
use App\Repositories\GeolocationRepository as Location;

class GeolocationController extends ApiController
{
    public $location;

    /**
     * Geolocation constructor.
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
        $this->middleware('jwt', ['except' => ['countries', 'states', 'cities']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        return $this->location->index($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->location->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, $id)
    {
        return $this->location->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->location->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $id)
    {
        return $this->location->destroy($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countries(Request $request)
    {
        return $this->ApiResponse(200, 'Successfully completed', Country::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function states(Request $request)
    {
        return $this->ApiResponse(200, 'Successfully completed', State::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cities(Request $request)
    {
        return $this->ApiResponse(200, 'Successfully completed', City::all());
    }
}
