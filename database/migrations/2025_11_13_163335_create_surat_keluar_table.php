<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('perihal')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('isi')->nullable();
            $table->string('file_pdf')->nullable(); // path file PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
