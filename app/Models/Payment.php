<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'amount_payed', 'id_method', 'bank', 'status',
		'property_id', 'transaction_ref','bcv', 'currency_id'
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
	 * Get the property record associated with the payments.
	 */
	public function property() {
		return $this->belongsTo(Property::class);
	}

	public function bank() {
		return $this->belongsTo(Bank::class, 'bank', 'id');
	}

	public function method() {
		return $this->belongsTo(Methods::class, 'id_method');
	}

	public function status() {
		return $this->belongsTo(status::class, 'status', 'id');
	}

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
