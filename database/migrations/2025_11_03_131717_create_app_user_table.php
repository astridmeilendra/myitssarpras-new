<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->id('userid');                      // PK
            $table->string('nama', 100);
            $table->integer('nrp')->nullable();
            $table->string('email_its', 150)->unique()->nullable();
            $table->string('password_hash', 200)->nullable();
            $table->string('prodi', 100)->nullable();
            $table->string('foto_profile', 255)->nullable();
            $table->string('no_telepon', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_user');
    }
};
