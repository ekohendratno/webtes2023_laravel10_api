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
        Schema::create('jabatan_pegawai', function (Blueprint $table) {
            $table->id('jabatan_pegawai_id');
            $table->integer('pegawai_id');
            $table->string('jabatan_pegawai_jabatan', 50);
            $table->integer('jabatan_pegawai_gaji');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_pegawai');
    }
};
