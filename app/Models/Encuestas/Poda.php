<?php

namespace App\Models\Encuestas;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;

class Poda extends Model
{
    protected $table = 'enc_podas';

    public static function setFoto($foto)
    {
        //Convirtiendo la Imagen a JPG con calidad del 75 %
        $image_normal = Image::make($foto)->encode('jpg', 75);
        //Codificando datos de imagen al esquema URI de datos 
        $data = (string) $image_normal->encode('data-url');

        return $data;

    }
}
