<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetupPayment extends Model {

    /**
     * this should be a calculator that shows up when the user is setting up billing
     * there should be a version that the Admin's can view to change or update the billing information
     */

    protected $fillable = [
        'numberOfProperties',
        'minimumPricing',
        'highestRentAmount',
        'payoutFee',
        'percentAmount',
        'fixedPricing',
        'pricingAmount',
        'user_id',
        'company_id', 
    ];

    // RELATIONSHIPS
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
