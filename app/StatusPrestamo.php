<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusPrestamo extends Model
{
    protected $table = 'tbl_status_prestamo';
    protected $primaryKey = 'id_status_prestamo';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_prestamo',
    ];
}
