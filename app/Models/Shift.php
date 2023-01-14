<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'jam_masuk',
        'jam_keluar',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
    ];

    // Relasi
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
