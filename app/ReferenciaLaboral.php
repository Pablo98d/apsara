<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciaLaboral extends Model
{
    protected $table = 'tbl_se_referencia_laboral';
    protected $primaryKey = 'id_referencia_laboral';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico',
    ];
}
