<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Se_Aval extends Model
{
    protected $table = 'tbl_se_aval';

    protected $primaryKey = 'id_sc_aval';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_aval','id_socio_economico','relacion_solicitante'
    ];
}
