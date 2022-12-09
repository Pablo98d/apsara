<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finanzas extends Model
{
    protected $table = 'tbl_se_finanzas';

    protected $primaryKey = 'id_finanza';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico','deuda_tarjeta_credito','deuda_otras_finanzas','pension_hijos','ingresos_mensuales','buro_credito'
    ];
}
