<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambahkan kolom yang hilang jika belum ada
            if (!Schema::hasColumn('peminjaman', 'ruanganid')) {
                $table->foreignId('ruanganid')
                      ->after('userid')
                      ->constrained('ruangan', 'ruanganid')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('peminjaman', 'tanggal')) {
                $table->date('tanggal')->after('ruanganid');
            }

            if (!Schema::hasColumn('peminjaman', 'nama_shift')) {
                $table->string('nama_shift', 50)->after('tanggal')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['ruanganid']);
            $table->dropColumnIfExists(['ruanganid', 'tanggal', 'nama_shift']);
        });
    }
};
