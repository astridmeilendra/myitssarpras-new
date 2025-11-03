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
            $table->foreignId('peminjamanid')
                  ->constrained('peminjaman', 'peminjamanid')
                  ->onDelete('cascade');
            $table->string('nama_ruangan', 100);
            $table->string('lokasi_ruangan', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->string('foto', 255)->nullable();
            $table->text('fasilitas')->nullable();
            $table->string('nama_shift', 50)->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
