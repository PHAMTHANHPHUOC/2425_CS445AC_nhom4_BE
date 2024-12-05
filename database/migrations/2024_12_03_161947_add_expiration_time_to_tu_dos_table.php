<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tu_dos', function (Blueprint $table) {
            $table->timestamp('expiration_time')->nullable(); // Thời gian hết hạn
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tu_dos', function (Blueprint $table) {
            $table->dropColumn('expiration_time');
        });
    }
};
