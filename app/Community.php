<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model {
    
    protected $fillable = [
        'hoa_community',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo('App\Company');
    }

}
