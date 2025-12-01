<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id('ruanganid');
            $table->string('nama_ruangan');
            $table->string('lokasi_ruangan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->string('foto')->nullable();
            $table->text('fasilitas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
