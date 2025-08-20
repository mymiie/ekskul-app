<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekskuls', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekskul');
            $table->text('deskripsi');
            $table->string('jadwal_latihan');
            $table->string('lokasi');
            $table->integer('max_peserta')->default(30);
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('status_aktif')->default(true);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekskuls');
    }
};