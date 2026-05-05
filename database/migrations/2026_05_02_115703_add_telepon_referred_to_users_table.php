<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telepon')->nullable()->after('email');
            $table->unsignedBigInteger('id_referred_by')->nullable()->after('telepon');
            $table->foreign('id_referred_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_referred_by']);
            $table->dropColumn(['telepon', 'id_referred_by']);
        });
    }
};