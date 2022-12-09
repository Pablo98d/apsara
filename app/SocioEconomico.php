<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocioEconomico extends Model
{
    protected $table = 'tbl_socio_economico';
    protected $primaryKey = 'id_socio_economico';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario','id_promotora','estatus','fecha_registro',
    ];
}
