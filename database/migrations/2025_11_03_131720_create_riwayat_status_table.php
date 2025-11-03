<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->id('statusid');
            $table->foreignId('peminjamanid')
                  ->constrained('peminjaman', 'peminjamanid')
                  ->onDelete('cascade');
            $table->string('nama_status', 50);
            $table->timestamp('waktu_update')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_status');
    }
};
