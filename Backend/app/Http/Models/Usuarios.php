<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Usuarios extends Authenticatable
{
    use AuthenticableTrait;
    protected $table = 'tb_usuarios';
    protected $primaryKey = 'cd_usuario';
    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getRememberToken()
    {
        return $this->senha;
    }
}
