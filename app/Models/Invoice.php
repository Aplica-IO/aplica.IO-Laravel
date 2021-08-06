<?php

namespace App\Models;

use App\Models\Charge;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'ref_code', 'total', 'residence_id','status_id',
		'date', 'currency', 'is_active','percentage_prontopago','start','end'
	];

	public $timestamps = false;

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at', 'updated_at',
	];

	/**
	 * Get the user record associated with the invoice.
	 */
	public function user() {
		return $this->hasMany(User::class);
	}

	/**
	 * Get the user record associated with the invoice.
	 */
	public function charges() {
		return $this->hasMany(Charge::class);
	}

	/**
	 * Get the property record associated with the invoice.
	 */
	public function residence() {
		return $this->belongsTo(Residence::class);
	}

	/**
	 * Get the user record associated with the invoice.
	 */

	public function properties() {
		return $this->belongsToMany(Property::class, 'payment_property_invoice');
	}

	/**
	 * Get the property record associated with the invoice.
	 */
	public function currency() {
		return $this->belongsTo(Currency::class, 'currency');
	}

	/**
	 * Get pronto pagos of the invoice.
	 */
	public function pronto_pagos() {
		return $this->hasMany(ProntoPago::class);
	}

}
