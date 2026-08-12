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
        Schema::create('motor_oil_details', function (Blueprint $table) {
            $table->id();
            $table->string('detal_kodu');
            $table->string('detal_adi');
            $table->string('olcu_vahidi')->nullable();
            $table->decimal('miqdar', 8, 2);
            $table->integer('km');
            $table->integer('say'); // neçə dəfə dəyişilir (Excel - dəki rəqəm)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor_oil_details');
    }
};
