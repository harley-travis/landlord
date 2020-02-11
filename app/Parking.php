<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model {
    
    protected $fillable = [
        'location',
        'type',
        'parking_deposit_amount',
        'monthly_fee',
        'avaliable',
        'company_id',
        'property_id',
    ];

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function property() {
        return $this->belongsTo('App\Property');
    }

}