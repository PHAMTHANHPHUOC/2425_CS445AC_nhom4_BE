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
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang')->nullable();
            $table->integer('tong_tien_thanh_toan')->nullable();
            $table->integer('is_thanh_toan')->default(0);
            $table->integer('tinh_trang')->default(0);
            $table->string('ho_va_ten');
            $table->string('so_dien_thoai');
            $table->string('dia_chi_giao_hang');
            $table->integer('id_khach_hang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};
