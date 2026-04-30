<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah tabel bookings sudah ada
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Tambah kolom jika belum ada
                if (!Schema::hasColumn('bookings', 'durasi')) {
                    $table->integer('durasi')->nullable()->after('book_id');
                }
                if (!Schema::hasColumn('bookings', 'tanggal_rencana_kembali')) {
                    $table->timestamp('tanggal_rencana_kembali')->nullable()->after('tanggal_disetujui');
                }
                if (!Schema::hasColumn('bookings', 'tanggal_kembali_aktual')) {
                    $table->timestamp('tanggal_kembali_aktual')->nullable()->after('tanggal_rencana_kembali');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn(['durasi', 'tanggal_rencana_kembali', 'tanggal_kembali_aktual']);
            });
        }
    }
};
