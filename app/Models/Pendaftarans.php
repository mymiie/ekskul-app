<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftarans extends Model
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

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isDiterima()
    {
        return $this->status === 'diterima';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}