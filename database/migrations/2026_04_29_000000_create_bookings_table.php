<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->integer('durasi')->nullable(); // Durasi peminjaman dalam hari
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_booking')->useCurrent();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamp('tanggal_rencana_kembali')->nullable(); // Dihitung saat approve
            $table->timestamp('tanggal_kembali_aktual')->nullable();
            $table->timestamps();

            // Index untuk query lebih cepat
            $table->index('siswa_id');
            $table->index('book_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
