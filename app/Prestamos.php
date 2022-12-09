<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    protected $table = 'tbl_prestamos';
    protected $primaryKey = 'id_prestamo';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario','fecha_solicitud','id_status_prestamo','id_grupo','id_promotora','id_producto','id_autorizo','fecha_aprovacion','fecha_entrega_recurso','cantidad'
    ];

    protected $dates=[
        'fecha_solicitud',
    ];
}
