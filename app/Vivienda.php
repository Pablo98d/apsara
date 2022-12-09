<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vivienda extends Model
{
    protected $table = 'tbl_vivienda';
    protected $primaryKey = 'id_vivienda';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico','tipo_vivienda','tiempo_viviendo_domicilio','telefono_casa','telefono_celular'
    ];
}
