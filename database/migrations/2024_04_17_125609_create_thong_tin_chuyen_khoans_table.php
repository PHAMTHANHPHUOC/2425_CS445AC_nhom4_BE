<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thong_tin_chuyen_khoans', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nguoi_nhan');
            $table->string('so_dien_thoai_nguoi_nhan');
            $table->text('link_qr_code');
            $table->integer('is_active')->default(0);
            $table->integer('id_khach_hang');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('thong_tin_chuyen_khoans');
    }
};
