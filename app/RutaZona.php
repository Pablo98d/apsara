<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RutaZona extends Model
{
    protected $table = 'tbl_rutas_zonas';
    protected $primaryKey = 'id_ruta_zona';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_dia','id_gerente_zona','id_grupo_promotora','fecha_registro',
    ];
}
