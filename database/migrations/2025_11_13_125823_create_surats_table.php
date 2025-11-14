<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('asal')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('perihal')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('file_path')->nullable(); // untuk upload arsip surat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
