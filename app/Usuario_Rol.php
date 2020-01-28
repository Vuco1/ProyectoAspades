<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario_Rol extends Model
{
    protected $table = 'usuario_rol';
    protected $primaryKey = 'Id_usurol';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
}
