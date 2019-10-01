<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model {
    
    protected $fillable = [
        'name',
        'phone',
        'work_phone',
        'email',
        'secondary_name',
        'secondary_phone',
        'secondary_work_phone',
        'secondary_email',
        'number_occupants',
        'active',
        'property_id',
        'user_id',
    ];

    public function property() {
        return $this->belongsTo('App\Property');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function company() {
        return $this->belongsToMany('App\Company');
    }

}
