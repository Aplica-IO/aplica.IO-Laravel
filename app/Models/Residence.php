<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'nif', 'address_id', 'auditor_id', 'community_type','reserve','reserve_percentage'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at', 'updated_at',
	];

	/**
	 * Get the property that owns the residence.
	 */
	public function properties() {
		return $this->hasMany(Property::class);
	}

	public function auditor() {
		return $this->belongsTo(User::class);
	}

	/**
	 * Get the address record that owns the residence.
	 */
	public function address() {
		return $this->belongsTo(Address::class);
	}

	public function payment() {
		return $this->hasManyThrough(Payment::class, Property::class);
	}

	public function invoices() {
		return $this->hasMany(Invoice::class);
	}
}
