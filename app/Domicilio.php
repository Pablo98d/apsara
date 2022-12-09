<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
	protected $table = 'tbl_domicilio';
    protected $primaryKey = 'id_domicilio';
    public $timestamps = false;

   protected $fillable = ['id_socio_economico','calle','numero_ext','numero_int','c_p','colonia_localidad','municipio','estado','pais',
	];
}
