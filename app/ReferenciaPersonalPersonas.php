<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciaPersonalPersonas extends Model
{
    protected $table = 'tbl_se_rp_personas';
    protected $primaryKey = 'id_rp_persona';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_referencia_personal','nombre','domicilio','telefono','relacion'
    ];
}
