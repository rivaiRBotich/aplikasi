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
        Schema::table('chat_tariffs', function (Blueprint $table) {
            // Menyimpan angka persentase, contoh: 80 untuk 80% (default 80)
            $table->integer('doctor_percentage')->default(80)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('chat_tariffs', function (Blueprint $table) {
            $table->dropColumn('doctor_percentage');
        });
    }
};
