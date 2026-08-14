<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_daily_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->date('tarix')->default(now()->toDateString());
            $table->string('status'); // Məsələn: "XƏTTƏ ÇIXMAĞA UYĞUN", "İSTİSMARA YARARSIZ(NASAZLIQ)" və s.
            $table->text('qeyd')->nullable();
            $table->timestamps();

            // Eyni gündə eyni avtobus üçün təkrar status olmasın
            $table->unique(['bus_id', 'tarix']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_daily_statuses');
    }
};
