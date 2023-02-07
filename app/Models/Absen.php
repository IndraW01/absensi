<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'telat_masuk',
        'latitude_absen_masuk',
        'longitude_absen_masuk',
        'jarak_masuk',
        'foto_absen_masuk',
        'jam_pulang',
        'pulang_cepat',
        'latitude_absen_pulang',
        'longitude_absen_pulang',
        'jarak_pulang',
        'foto_absen_pulang',
        'status',
    ];

    public function scopeAbsen(Builder $query, $tanggalHariIni)
    {
        return $query->whereUserId(Auth::id())->whereDate('tanggal', $tanggalHariIni);
    }
}
