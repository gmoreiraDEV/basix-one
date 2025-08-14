<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['id','name','slug','domain'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function settings() {
        return $this->hasOne(TenantSetting::class, 'tenant_id');
    }
}
