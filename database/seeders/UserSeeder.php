<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name'     => 'Admin Perpustakaan',
            'email'    => 'admin@library.sch.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Akun Siswa (10 siswa)
        $siswa = [
            ['name' => 'Budi Santoso',    'email' => 'budi@siswa.sch.id'],
            ['name' => 'Siti Rahayu',     'email' => 'siti@siswa.sch.id'],
            ['name' => 'Ahmad Fauzi',     'email' => 'ahmad@siswa.sch.id'],
            ['name' => 'Dewi Lestari',    'email' => 'dewi@siswa.sch.id'],
            ['name' => 'Rizky Pratama',   'email' => 'rizky@siswa.sch.id'],
            ['name' => 'Nurul Hidayah',   'email' => 'nurul@siswa.sch.id'],
            ['name' => 'Fajar Ramadhan',  'email' => 'fajar@siswa.sch.id'],
            ['name' => 'Anisa Putri',     'email' => 'anisa@siswa.sch.id'],
            ['name' => 'Dimas Arya',      'email' => 'dimas@siswa.sch.id'],
            ['name' => 'Lina Marlina',    'email' => 'lina@siswa.sch.id'],
        ];

        foreach ($siswa as $s) {
            User::create([
                'name'     => $s['name'],
                'email'    => $s['email'],
                'password' => Hash::make('password'),
                'role'     => 'siswa',
            ]);
        }
    }
}