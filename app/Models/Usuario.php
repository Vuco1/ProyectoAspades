<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'Id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
}
