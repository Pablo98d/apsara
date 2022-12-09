<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Negociacion extends Model
{
    protected $table = 'tbl_negociacion';

    protected $primaryKey = 'id_negociacion';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_prestamo','cantidad_propuesta','status','fecha_registro',
    ];
    // protected $dates=[
    //     'fecha_pago',
    // ];
}
