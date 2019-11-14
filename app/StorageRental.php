<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorageRental extends Model {
    
    protected $fillable = [
        'unit_number', 
        'unit_type', 
        'description', 
        'features', 
        'status',
        'end_date',
        'company_id',
        'user_id',
    ];

    // RELATIONSHIPS
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }


}
