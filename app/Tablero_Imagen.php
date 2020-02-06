<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablero_Imagen extends Model
{
    protected $table = 'tablero_imagen';
    protected $primaryKey = 'Id_tabimag';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
}
