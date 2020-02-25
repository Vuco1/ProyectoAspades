<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablero_Dimension extends Model {

    protected $table = 'tablero_dimension';
    protected $primaryKey = 'Id_tabdim';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

}
