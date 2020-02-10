<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'Id_imagen';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
}
