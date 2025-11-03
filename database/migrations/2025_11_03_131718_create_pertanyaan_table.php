<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id('pertanyaanid');
            $table->foreignId('userid')
                  ->constrained('app_user', 'userid')
                  ->onDelete('cascade');
            $table->text('isi_pertanyaan');
            $table->string('lampiran', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
