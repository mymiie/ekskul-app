<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ekskul_id',
        'status',
        'alasan_daftar',
        'tanggal_daftar',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];

    // Relasi: Pendaftaran milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Pendaftaran milik satu Ekskul
    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }
}
