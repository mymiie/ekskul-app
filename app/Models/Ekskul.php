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

    // Relationships
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftarans::class);
    }

    public function peserta()
    {
        return $this->belongsToMany(User::class, 'pendaftarans')
                    ->withPivot('status', 'tanggal_daftar', 'alasan_daftar')
                    ->withTimestamps();
    }

    public function pesertaDiterima()
    {
        return $this->peserta()->wherePivot('status', 'diterima');
    }

    // Helper methods
    public function getJumlahPeserta()
    {
        return $this->pesertaDiterima()->count();
    }

    public function isFull()
    {
        return $this->getJumlahPeserta() >= $this->max_peserta;
    }

    public function canRegister()
    {
        return $this->status_aktif && !$this->isFull();
    }
}