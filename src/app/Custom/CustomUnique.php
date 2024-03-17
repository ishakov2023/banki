<?php

namespace App\Custom;

use Illuminate\Support\Str;

class CustomUnique
{
    public function __invoke($filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
        $newFilename = Str::slug($filenameWithoutExtension) . '_' . uniqid() . '.' . $extension;
        return $newFilename;
    }
}
