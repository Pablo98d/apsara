<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosGenerales extends Model
{
    protected $table = 'tbl_se_datos_generales';

    protected $primaryKey = 'id_datos_generales';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        	'id_socio_economico','curp','nombre','ap_paterno','ap_materno','fecha_nacimiento','edad','ocupacion','genero','estado_civil','rfc_homo_clave','regimen_matrimonial','pais_nacimiento','nacionalidad','ciudad_nacimiento',
    ];
    public $timestamps = false;
}
