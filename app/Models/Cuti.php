<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'tanggal',
        'alasan_cuti',
        'catatan',
        'status',
        'foto',
    ];
}
