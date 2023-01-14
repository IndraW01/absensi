<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'latitude_kantor',
        'longitude_kantor',
        'radius',
    ];

    // Relasi
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
