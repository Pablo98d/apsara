<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pareja extends Model
{
    protected $table = 'tbl_pareja';
    protected $primaryKey = 'id_pareja';
    public $timestamps = false;

   protected $fillable = ['id_socio_economico','nombre','ap_paterno','ap_materno','telefono','edad','ocupacion'
	];
}
