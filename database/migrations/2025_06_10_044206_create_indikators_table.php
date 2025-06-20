<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indikators', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->foreignId('area_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_area_id')->constrained()->onDelete('cascade');
            $table->string('nama_indikator')->nullable(); 
            $table->enum('tipe_jawaban', ['ya/tidak', 'abcde']);
            $table->integer('bobot');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikators');
    }
};
