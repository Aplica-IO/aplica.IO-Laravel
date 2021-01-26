<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'amount', 'reason', 'invoice_id', 'type', 'spend_date','bcv','propertyId'
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
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'amount' => 'float',
	];

	/**
	 * The payment that belong to the charges.
	 */
	public function invoice() {
		return $this->belongsTo(Invoice::class);
	}
}
