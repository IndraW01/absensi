<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'lokasi_id',
        'shift_id',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'status',
        'foto',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userCuti()
    {
        return $this->hasOne(UserCuti::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
