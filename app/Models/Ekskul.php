<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ekskul',
        'deskripsi',
        'jadwal_latihan',
        'lokasi',
        'max_peserta',
        'guru_id',
        'status_aktif',
        'gambar',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    // Relasi: Satu Ekskul punya banyak Pendaftar
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
