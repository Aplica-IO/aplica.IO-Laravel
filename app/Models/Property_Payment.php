<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Property_Payment extends Model
{
    protected $table = 'payment_property_invoice';
    protected $fillable = [
        'property_id', 'payment_id', 'invoice_id'
    ];

    public function property()
    {
        return $this->belongsToMany(Payment::class, 'payment_property_invoice')->withPivot('property_id');
    }

    public function invoice()
    {
        return $this->belongsToMany(Invoice::class, 'payment_property_invoice')->withPivot('property_id');
    }

    public function payment()
    {
        return $this->belongsToMany(Payment::class, 'payment_property_invoice')->withPivot('payment_id');
    }
}
