<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Abonos extends Model
{
    protected $table = 'tbl_abonos';

    protected $primaryKey = 'id_abono';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_prestamo','semana','cantidad','fecha_pago','id_tipoabono','id_corte_semana',
    ];
    protected $dates=[
        'fecha_pago',
    ];
}
