<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket_regulers', function (Blueprint $table) {
            $table->foreignId('id_ticket')->constrained('tikets', 'id_ticket')->onDelete('cascade');
            $table->string('zona', 50)->nullable();
            $table->primary('id_ticket');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_regulers');
    }
};