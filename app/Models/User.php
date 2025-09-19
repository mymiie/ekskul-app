<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis',
        'nip',
        'kelas',
        'alamat',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function ekskulYangDiampu()
    {
        return $this->hasMany(Ekskul::class, 'guru_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function ekskulYangDiikuti()
    {
        return $this->belongsToMany(Ekskul::class, 'pendaftaran')
                    ->withPivot('status', 'tanggal_daftar', 'alasan_daftar')
                    ->withTimestamps();
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function getIdentifier()
    {
        if ($this->isUser()) {
            return $this->nis;
        } elseif ($this->isGuru()) {
            return $this->nip;
        }
        return $this->email;
    }
}