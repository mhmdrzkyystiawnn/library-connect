<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting! User dulu, baru Siswa, baru Book, terakhir Peminjaman
        $this->call([
            UserSeeder::class,
            SiswaSeeder::class,
            BookSeeder::class,
            PeminjamanSeeder::class,
        ]);
    }
}