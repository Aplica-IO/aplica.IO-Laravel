<?php

namespace App\Models;

use App\Models\City;
use App\Models\Country;
use App\Models\Residence;
use App\Models\State;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'location', 'street', 'zip_code', 'country_id', 'state_id', 'city_id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'country_id', 'state_id', 'city_id', 'created_at', 'updated_at',
	];

	/**
	 * Get the address that owns the country.
	 */
	public function country() {
		return $this->belongsTo(Country::class);
	}

	/**
	 * Get the state record associated with the address.
	 */

	public function state() {
		return $this->belongsTo(State::class);
	}

	/**
	 * Get the city record associated with the address.
	 */

	public function city() {
		return $this->belongsTo(City::class);
	}

	/**
	 * Get the address that owns the city.
	 */
	public function residence() {
		return $this->belongsTo(Residence::class);
	}
}