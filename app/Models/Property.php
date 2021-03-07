<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Residence;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Property extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'reference', 'alicuota', 'is_active', 'residence_id', 'user_id','balance'
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
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'is_active' => 'boolean',
	];

	/**
	 * Get the user record associated with the property.
	 */
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the property that owns the payments.
	 */
	public function payments() {
		return $this->hasMany(Payment::class);
	}

	public function invoice() {
		return $this->belongsToMany(Invoice::class, 'payment_property_invoice')->withPivot('payment_id');
	}

	public function residence() {
		return $this->belongsTo(Residence::class);
	}
}
