<?php
// database/seeders/SiswaSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user role siswa (skip index 0 = admin)
        $users = User::where('role', 'siswa')->get();

        $data = [
            ['nis' => '2024001', 'kelas' => 'XII IPA 1', 'no_hp' => '081234567001'],
            ['nis' => '2024002', 'kelas' => 'XII IPA 2', 'no_hp' => '081234567002'],
            ['nis' => '2024003', 'kelas' => 'XII IPS 1', 'no_hp' => '081234567003'],
            ['nis' => '2024004', 'kelas' => 'XI IPA 1', 'no_hp' => '081234567004'],
            ['nis' => '2024005', 'kelas' => 'XI IPA 2', 'no_hp' => '081234567005'],
            ['nis' => '2024006', 'kelas' => 'XI IPS 1', 'no_hp' => '081234567006'],
            ['nis' => '2024007', 'kelas' => 'X IPA 1',  'no_hp' => '081234567007'],
            ['nis' => '2024008', 'kelas' => 'X IPA 2',  'no_hp' => '081234567008'],
            ['nis' => '2024009', 'kelas' => 'X IPS 1',  'no_hp' => '081234567009'],
            ['nis' => '2024010', 'kelas' => 'X IPS 2',  'no_hp' => '081234567010'],
        ];

        foreach ($users as $index => $user) {
            Siswa::create([
                'user_id' => $user->id,
                'nama'    => $user->name,
                'nis'     => $data[$index]['nis'],
                'kelas'   => $data[$index]['kelas'],
                'no_hp'   => $data[$index]['no_hp'],
            ]);
        }
    }
}