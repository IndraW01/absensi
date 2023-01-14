<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_detail_id',
        'cuti',
        'cuti_bersama',
        'cuti_menikah',
        'cuti_melahirkan',
    ];

    // Relasi
    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class);
    }
}
