<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    protected $table = 'tb_usuarios';
    protected $primaryKey = 'cd_usuario';
    public $timestamps = false;
}
