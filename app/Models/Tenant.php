<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'domain', 'primary_color', 'secondary_color',
        'logo_url', 'email_from'
    ];    
    public $incrementing = false;
    protected $keyType = 'string';

    public function settings() {
        return $this->hasOne(TenantSetting::class, 'tenant_id');
    }
}
