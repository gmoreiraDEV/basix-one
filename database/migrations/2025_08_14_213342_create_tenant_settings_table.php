<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tenant_settings', function (Blueprint $t) {
            $t->uuid('tenant_id')->primary(); // 1-para-1 com tenants
            $t->string('brand_name')->nullable();
            $t->string('logo_url')->nullable();
            $t->string('primary_color')->nullable();
            $t->string('secondary_color')->nullable();
            $t->string('email_from')->nullable();
            $t->json('features')->nullable(); // flags do plano (ex.: {"crm":true,"erp":true})
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tenant_settings');
    }
};
