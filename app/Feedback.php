<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {
    
    protected $fillable = [
        'subject', 
        'description', 
        'status',
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
