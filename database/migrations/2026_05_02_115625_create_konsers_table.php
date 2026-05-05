<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsers', function (Blueprint $table) {
            $table->id('id_concert');
            $table->string('nama_concert', 100);
            $table->date('tanggal');
            $table->time('waktu');
            $table->decimal('harga_dasar', 10, 2);
            $table->foreignId('id_venue')->constrained('venues', 'id_venue')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsers');
    }
};