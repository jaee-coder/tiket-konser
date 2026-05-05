<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus foreign key yang lama
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropForeign(['id_concert']);
        });

        // Tambah foreign key baru dengan ON DELETE CASCADE
        Schema::table('tikets', function (Blueprint $table) {
            $table->foreign('id_concert')
                  ->references('id_concert')->on('konsers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropForeign(['id_concert']);
            $table->foreign('id_concert')
                  ->references('id_concert')->on('konsers');
        });
    }
};