<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
     protected $table = 'tableros';
    protected $primaryKey = 'Id_tablero';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
}
