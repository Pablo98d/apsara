<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TipoUsuario extends Model
{

    protected $table = 'tbl_tipo_usuario';

    protected $primaryKey = 'id_tipo_usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    public $timestamps = false;
}