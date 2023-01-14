<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuti',
        'cuti_bersama',
        'cuti_menikah',
        'cuti_melahirkan',
    ];
}
