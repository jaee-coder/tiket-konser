<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kursis', function (Blueprint $table) {
            $table->foreignId('id_venue')->constrained('venues', 'id_venue')->onDelete('cascade');
            $table->string('nomor_kursi', 10);
            $table->string('baris', 5)->nullable();
            $table->string('tipe_kursi', 20)->nullable();
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->primary(['id_venue', 'nomor_kursi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kursis');
    }
};