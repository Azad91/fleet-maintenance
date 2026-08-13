<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('soyad');
            $table->string('vezifesi');
            $table->boolean('aktiv')->default(true);
            $table->text('qeyd')->nullable();
            $table->timestamps();
        });

        // Şikayətlər cədvəlinə employee_id əlavə et
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropConstrainedForeignId('employee_id');
        });
        Schema::dropIfExists('employees');
    }
};
