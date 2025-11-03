<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id('jawabanid');
            $table->foreignId('pertanyaanid')
                  ->constrained('pertanyaan', 'pertanyaanid')
                  ->onDelete('cascade');
            $table->text('isi_jawaban');
            $table->timestamps();

            $table->unique('pertanyaanid'); // biar 1 pertanyaan cuma 1 jawaban
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
