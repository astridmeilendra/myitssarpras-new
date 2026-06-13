<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pertanyaan')) {
            Schema::table('pertanyaan', function (Blueprint $table) {
                if (!Schema::hasColumn('pertanyaan', 'sifat')) {
                    $table->string('sifat', 20)->default('rendah');
                }

                if (!Schema::hasColumn('pertanyaan', 'lampiran')) {
                    $table->text('lampiran')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pertanyaan')) {
            Schema::table('pertanyaan', function (Blueprint $table) {
                if (Schema::hasColumn('pertanyaan', 'sifat')) {
                    $table->dropColumn('sifat');
                }

                if (Schema::hasColumn('pertanyaan', 'lampiran')) {
                    $table->dropColumn('lampiran');
                }
            });
        }
    }
};
