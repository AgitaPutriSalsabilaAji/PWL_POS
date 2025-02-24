<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id'); // Primary Key
            $table->foreignId('user_id')->constrained('m_user', 'user_id')->onDelete('cascade');
            $table->string('pembeli', 50);
            $table->string('penjualan_kode', 20);
            $table->datetime('penjualan_tanggal');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('t_penjualan');
    }
};
