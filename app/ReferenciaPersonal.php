<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciaPersonal extends Model
{
    protected $table = 'tbl_se_referencia_personal';
    protected $primaryKey = 'id_referencia_personal';
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
