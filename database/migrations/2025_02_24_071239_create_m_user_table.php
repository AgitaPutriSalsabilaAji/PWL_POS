<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id'); // Primary Key
            $table->foreignId('level_id')->constrained('m_level', 'level_id')->onDelete('cascade');
            $table->string('username', 20)->unique();
            $table->string('nama', 100);
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('m_user');
    }
};
