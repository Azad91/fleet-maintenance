<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Koropka Yağ Dəyişməsi", "Motor Yağ Dəyişməsi"
            $table->integer('default_km_interval'); // 180000, 36000, 72000
            $table->json('details'); // [{"kodu":"YAG-001", "adi":"Koropka Yağı", "miqdar":3}]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_templates');
    }
};
