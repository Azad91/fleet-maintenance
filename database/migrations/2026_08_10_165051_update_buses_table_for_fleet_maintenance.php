<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buses', function (Blueprint $table) {
            // Yeni sütunları əlavə et (constraint - ləri dəyişmədən)
            $table->date('bildirilme_tarix')->nullable()->after('shikayet');
            $table->time('bildirilme_saat')->nullable()->after('bildirilme_tarix');
            $table->date('is_baslama_tarix')->nullable()->after('bildirilme_saat');
            $table->time('is_baslama_saat')->nullable()->after('is_baslama_tarix');
            $table->date('is_bitme_tarix')->nullable()->after('is_baslama_saat');
            $table->time('is_bitme_saat')->nullable()->after('is_bitme_tarix');
            $table->string('surucu_adi')->nullable()->after('is_bitme_saat');
            $table->json('detallar')->nullable()->after('surucu_adi');
        });
    }

    public function down(): void
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn([
                'bildirilme_tarix',
                'bildirilme_saat',
                'is_baslama_tarix',
                'is_baslama_saat',
                'is_bitme_tarix',
                'is_bitme_saat',
                'surucu_adi',
                'detallar',
            ]);
        });
    }
};
