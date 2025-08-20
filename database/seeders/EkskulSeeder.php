<?php

namespace Database\Seeders;

use App\Models\Ekskul;
use App\Models\User;
use Illuminate\Database\Seeder;

class EkskulSeeder extends Seeder
{
    public function run(): void
    {
        $guruBasket = User::where('nip', '196801011993031001')->first();
        $guruVoli = User::where('nip', '197205152000032001')->first();
        $guruTeater = User::where('nip', '198003102005011001')->first();

        Ekskul::create([
            'nama_ekskul' => 'Basket',
            'deskripsi' => 'Ekstrakurikuler olahraga basket untuk mengembangkan kemampuan bermain basket, kerjasama tim, dan kondisi fisik. Cocok untuk siswa yang menyukai olahraga yang menantang dan dinamis.',
            'jadwal_latihan' => 'Selasa & Kamis, 15:30 - 17:00',
            'lokasi' => 'Lapangan Basket Sekolah',
            'max_peserta' => 20,
            'guru_id' => $guruBasket->id,
            'status_aktif' => true,
        ]);

        Ekskul::create([
            'nama_ekskul' => 'Voli',
            'deskripsi' => 'Ekstrakurikuler olahraga voli yang melatih koordinasi, kekuatan, dan strategi bermain. Mengajarkan teknik dasar hingga mahir dalam permainan bola voli.',
            'jadwal_latihan' => 'Senin & Rabu, 15:30 - 17:00',
            'lokasi' => 'Lapangan Voli Sekolah',
            'max_peserta' => 24,
            'guru_id' => $guruVoli->id,
            'status_aktif' => true,
        ]);

        Ekskul::create([
            'nama_ekskul' => 'Teater',
            'deskripsi' => 'Ekstrakurikuler seni peran yang mengembangkan kemampuan acting, public speaking, dan kreativitas. Siswa akan belajar berbagai teknik peran dan mementaskan berbagai karya teater.',
            'jadwal_latihan' => 'Jumat, 14:00 - 16:00',
            'lokasi' => 'Aula Sekolah',
            'max_peserta' => 15,
            'guru_id' => $guruTeater->id,
            'status_aktif' => true,
        ]);

        // Ekskul tanpa guru (untuk demo admin assignment)
        Ekskul::create([
            'nama_ekskul' => 'Futsal',
            'deskripsi' => 'Ekstrakurikuler olahraga futsal yang mengajarkan teknik bermain futsal, strategi tim, dan sportivitas. Cocok untuk siswa yang menyukai sepak bola.',
            'jadwal_latihan' => 'Sabtu, 08:00 - 10:00',
            'lokasi' => 'Lapangan Futsal',
            'max_peserta' => 18,
            'guru_id' => null,
            'status_aktif' => false,
        ]);
    }
}