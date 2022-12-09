<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciaLaboralPersonas extends Model
{
    protected $table = 'tbl_se_rl_personas';
    protected $primaryKey = 'id_rl_persona';
    public $timestamps = false;

   protected $fillable = ['id_referencia_laboral','nombre_empresa','actividad_empresa','cargo_empresa','direccion','numero_ext','numero_int','calle','telefono_empresa','tiempo_empresa','municipio_ciudad','ext','pagina_web','sueldo','otros','estado','codigo_postal','pais'
	];
}
