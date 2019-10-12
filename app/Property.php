<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model {
    
    protected $casts = [
        'company_id',
    ];

    protected $fillable = [
        'address_1',
        'address_2',
        'address_3',
        'city',
        'state',
        'zip',
        'country',
        'occupied',
        'lease_length',
        'rent_amount',
        'pet',
        'deposit_amount',
        'pet_deposit_amount',
        'amount_refundable',
        'bed_amount',
        'bath_amount',
        'square_footage',
        'description',
        'community_id',
        'hoa_amount',
        'account_number',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo('App\Company');
    }

}
