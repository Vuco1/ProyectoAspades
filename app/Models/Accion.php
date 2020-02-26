<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model {

    protected $table = 'acciones';
    protected $primaryKey = 'Id_accion';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

}
