<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $table = 'tenant_settings';
    protected $primaryKey = 'tenant_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tenant_id','brand_name','logo_url',
        'primary_color','secondary_color','email_from','features'
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
