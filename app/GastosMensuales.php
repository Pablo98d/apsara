<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GastosMensuales extends Model
{
    protected $table = 'tbl_gastos_mensuales';
    protected $primaryKey = 'id_gasto_mensual';
    public $timestamps = false;

   protected $fillable = ['id_socio_economico','renta_hipoteca','telefono_fijo','internet','telefono_movil','cable','luz','gas'
	];
}
