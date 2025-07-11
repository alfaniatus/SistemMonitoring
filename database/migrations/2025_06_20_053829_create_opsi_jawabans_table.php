<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('opsi_jawabans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('indikator_id')->constrained()->onDelete('cascade');
    $table->string('opsi'); 
    $table->string('teks'); 
    $table->decimal('bobot', 5, 2)->nullable(); 
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_jawabans');
    }
};
