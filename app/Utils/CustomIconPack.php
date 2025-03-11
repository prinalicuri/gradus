<?php

namespace App\Utils;

class CustomIconPack
{
    public static function getFolder(): string
    {
        return base_path('public/icons'); // Ruta donde se almacenan los iconos
    }
}