<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('indikator_periode', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('indikator_id');
        $table->unsignedBigInteger('periode_id');
        $table->boolean('published')->default(false);
        $table->timestamps();

        $table->unique(['indikator_id', 'periode_id']);

        // Foreign keys, perhatikan nama tabel harus plural sesuai migrasi
        $table->foreign('indikator_id')->references('id')->on('indikators')->onDelete('cascade');
        $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_periodes');
    }
};
