<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GastosSemanales extends Model
{
    protected $table = 'tbl_gastos_semanales';
    protected $primaryKey = 'id_gasto_semanal';
    public $timestamps = false;

   protected $fillable = ['id_socio_economico','alimentos','transporte_publico','gasolina','educacion','diversion','medicamentos','deportes'
	];
}
