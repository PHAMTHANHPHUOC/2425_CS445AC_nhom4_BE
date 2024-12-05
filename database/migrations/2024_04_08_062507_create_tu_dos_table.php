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
        Schema::create('tu_dos', function (Blueprint $table) {
            $table->id();
            $table->string('ten_san_pham');
            $table->text('hinh_anh');
            $table->integer('gia_ban');
            $table->integer('is_active')->default(0);
            $table->integer('has_active')->default(0);
            $table->integer('pin_active')->default(0);
            $table->integer('id_khach_hang')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tu_dos');
    }
};
