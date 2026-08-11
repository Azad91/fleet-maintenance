<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('yer')->nullable()->after('bus_id');
            $table->string('detal_kodu')->nullable()->after('kim_is_gorub');
            $table->string('detal_adi')->nullable()->after('detal_kodu');
            $table->integer('depo_miqdari')->nullable()->after('detal_adi');
            $table->integer('islenen_miqdar')->nullable()->after('depo_miqdari');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['yer', 'detal_kodu', 'detal_adi', 'depo_miqdari', 'islenen_miqdar']);
        });
    }
};
