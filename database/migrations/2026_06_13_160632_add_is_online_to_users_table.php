<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         $table->boolean('is_online')->default(false)->after('role');
    //         $table->timestamp('last_seen_at')->nullable()->after('is_online');
    //     });
    // }

    // public function down()
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         $table->dropColumn(['is_online', 'last_seen_at']);
    //     });
    // }
};
