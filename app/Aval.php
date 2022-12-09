<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aval extends Model
{
    protected $table = 'tbl_avales';

    protected $primaryKey = 'id_aval';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'curp','nombre','ap_paterno','ap_materno','fecha_nacimiento','edad','ocupacion','genero','estado_civil','calle','numero_ext','numero_int','entre_calles','colonia','municipio','estado','referencia_visual','vivienda','tiempo_viviendo_domicilio','telefono_casa','telefono_movil','telefono_trabajo','estatus_aval','fecha_registro'
    ];
}
