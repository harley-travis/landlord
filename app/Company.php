<?php

namespace App;

use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    
    protected $fillable = [
        'name', 
        'product',
    ];

    public function maintenances() {
        return $this->hasMany('App\Maintenance');
    }

    public function tenants() {
        return $this->belongsToMany('App\Tenant')->withPivot('tenant_id', 'company_id');
    }

}
