<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyTenant extends Model {
    
    protected $fillable = [
        'company_id',
        'tenant_id',
    ];
    
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function tenant() {
        return $this->belongsTo('App\Tenant');
    }

}
