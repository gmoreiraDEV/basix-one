<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tenants', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name');
            $t->string('slug')->unique();   // ex.: acme
            $t->string('domain')->nullable(); // ex.: acme.com (opcional)
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tenants');
    }
};
