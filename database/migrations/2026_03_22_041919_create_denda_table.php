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
    Schema::create('denda', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
        $table->integer('hari_terlambat');
        $table->integer('nominal_per_hari')->default(1000); // Rp1.000/hari
        $table->integer('total_denda');
        $table->enum('status_bayar', ['belum', 'sudah'])->default('belum');
        $table->timestamp('dibayar_pada')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
