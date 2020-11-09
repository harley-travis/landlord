<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model {
    
    protected $fillable = [
        'last_date_paid',
        'next_due_date',
        'rent_amount',
        'deposit_amount',
        'pet_deposit_amount',
        'amount_refundable',
        'lease_length',
        'balance',
        'late_date',
        'late_fee',
        'account_number',
        'hoa_amount',
        'property_id',
        'company_id',
    ];

    public function property() {
        return $this->belongsTo('App\Property');
    }

}
