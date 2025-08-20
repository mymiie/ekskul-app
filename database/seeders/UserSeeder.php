<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ekskul.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Guru
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.guru@ekskul.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '196801011993031001',
            'no_hp' => '081234567890',
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.guru@ekskul.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '197205152000032001',
            'no_hp' => '081234567891',
        ]);

        User::create([
            'name' => 'Ahmad Rahman',
            'email' => 'ahmad.guru@ekskul.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '198003102005011001',
            'no_hp' => '081234567892',
        ]);

        // Siswa/User
        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@siswa.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'nis' => '2024001',
            'kelas' => 'X IPA 1',
            'alamat' => 'Jl. Merdeka No. 1',
            'no_hp' => '081234567893',
        ]);

        User::create([
            'name' => 'Dewi Sari',
            'email' => 'dewi@siswa.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'nis' => '2024002',
            'kelas' => 'X IPA 2',
            'alamat' => 'Jl. Kemerdekaan No. 2',
            'no_hp' => '081234567894',
        ]);

        User::create([
            'name' => 'Riko Saputra',
            'email' => 'riko@siswa.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'nis' => '2024003',
            'kelas' => 'XI IPS 1',
            'alamat' => 'Jl. Pahlawan No. 3',
            'no_hp' => '081234567895',
        ]);
    }
}