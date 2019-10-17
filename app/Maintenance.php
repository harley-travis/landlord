<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model {
    
    protected $fillable = [
        'subject', 
        'type', 
        'description', 
        'emergency', 
        'permission', 
        'status',
        'notes',
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
