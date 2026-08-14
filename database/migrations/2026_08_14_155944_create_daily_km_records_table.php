<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_km_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->date('tarix');
            $table->integer('km')->unsigned(); // Yürüş (kilometr)
            $table->text('qeyd')->nullable();  // Əlavə qeyd (isteğe bağlı)
            $table->timestamps();

            // Eyni avtobus üçün eyni tarixdə təkrar qeyd olmasın
            $table->unique(['bus_id', 'tarix']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_km_records');
    }
};
