<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosUsuario extends Model
{
    protected $table = 'tbl_datos_usuario';

    protected $primaryKey = 'id_datos_usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        	'id_usuario','nombre','ap_paterno','ap_materno','telefono_casa','telefono_celular','direccion','numero_exterior','numero_interior','colonia','codigo_postal','localidad','municipio','estado','latitud','longitud',
    ];
    public $timestamps = false;
}
