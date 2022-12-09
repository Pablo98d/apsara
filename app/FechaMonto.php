<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaMonto extends Model
{
    protected $table = 'tbl_fecha_monto';

    protected $primaryKey = 'id_referencia';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico','fecha_credito','monto_credito'
    ];
}
