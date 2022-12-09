<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRuta extends Model
{
    protected $table = 'tbl_detalle_ruta';

    protected $primaryKey = 'id_detalle_ruta';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_ruta','id_tipo_visita','prioridad','latitud','longitud','observaciones','tiempo_estimado',
    ];
}
