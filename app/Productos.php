<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'tbl_productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

   protected $fillable = ['producto','rango_inicial','rango_final','semanas','papeleria','comision_promotora','comision_cobro_perfecto','penalizacion','pago_semanal','reditos','ultima_semana'
	];
}
