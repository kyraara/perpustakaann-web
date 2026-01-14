<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpus.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Kepala Sekolah
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@perpus.test',
            'password' => bcrypt('password'),
            'role' => 'kepala_sekolah',
        ]);

        // Sample Siswa
        User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@perpus.test',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'nisn' => '0012345678',
            'kelas' => '6A',
        ]);

        User::create([
            'name' => 'Siti Aisyah',
            'email' => 'siti@perpus.test',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'nisn' => '0012345679',
            'kelas' => '5B',
        ]);
    }
}
