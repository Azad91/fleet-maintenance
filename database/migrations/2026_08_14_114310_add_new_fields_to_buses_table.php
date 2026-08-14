<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buses', function (Blueprint $table) {
            // YENİ SAHƏLƏR
            $table->string('bus_project')->nullable()->after('id');
            $table->string('vin', 17)->nullable()->after('bus_project');
            $table->decimal('uzunluq', 5, 2)->nullable()->after('vin');
            $table->string('motor_no')->nullable()->after('dqn');
        });
    }

    public function down(): void
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn(['bus_project', 'vin', 'uzunluq', 'motor_no']);
        });
    }
};
