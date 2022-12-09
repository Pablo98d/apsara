<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalizacion extends Model
{
    protected $table = 'tbl_penalizacion';
    protected $primaryKey = 'id_penalizacion';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_prestamo','id_abono'
    ];
}
