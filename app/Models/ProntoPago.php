<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;

class ProntoPago extends Model
{
    protected $fillable = [
        'property_id', 'invoice_id', 'command_date', 'amount',
        'residence_id', 'charge_id', 'is_applied'
    ];

    public function property() {
        return $this->belongsTo(Property::class);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function charge() {
		return $this->belongsTo(Charge::class);
	}
}
