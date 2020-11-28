<<<<<<< HEAD
<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

class Deficiencia extends Model
{
    protected $table = 'enc_deficiencias';
}
=======
<?php

namespace App\Models\Encuestas;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;

class Deficiencia extends Model
{
  protected $table = 'enc_deficiencias';

  public static function setFoto($foto)
  {
      //Convirtiendo la Imagen a JPG con calidad del 75 %
      $image_normal = Image::make($foto)->encode('jpg', 75);
      //Codificando datos de imagen al esquema URI de datos
      $data = (string) $image_normal->encode('data-url');

      return $data;

  }
}
>>>>>>> d532c47827818c93b83c2d9448478090eb55a9f0
