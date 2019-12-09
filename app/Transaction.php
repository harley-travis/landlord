<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    
    protected $fillable = [
        'tenant_id',
        'landlord_id',
        'property_id',
        'amount_paid',
        'payment_method',
        'paid_in_full',
        'late_fee_amount',
        'confirmation',
    ];

    public function tenant() {
        return $this->belongsTo('App\Tenant');
    }

    public function landlord() {
        return $this->belongsTo('App\Users');
    }

    public function property() {
        return $this->belongsTo('App\Property');
    }


}
