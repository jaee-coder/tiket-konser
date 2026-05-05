<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->string('kode_tiket', 50)->unique();
            $table->enum('status', ['booking', 'paid', 'cancelled'])->default('booking');
            $table->datetime('tanggal_pembelian');
            $table->decimal('harga_jual', 10, 2);
            $table->foreignId('id_concert')->constrained('konsers', 'id_concert');
            $table->foreignId('id_customer')->constrained('users', 'id');
            $table->foreignId('id_payment')->nullable()->constrained('pembayarans', 'id_payment');
            $table->enum('tipe', ['reguler', 'vip']);
            $table->string('nomor_kursi', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};