<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class UploadFotoService
{
    public function upload(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();

        $namaFoto = 'profile-' . random_int(1, 100) . time() . '.' . $extension;

        $file->storePubliclyAs('public/profile', $namaFoto);

        return $namaFoto;
    }
}
