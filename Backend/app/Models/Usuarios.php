<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'tb_usuarios';
    protected $primaryKey = 'cd_usuario';
    public $timestamps = false;
}
