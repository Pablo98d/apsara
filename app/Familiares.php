<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Familiares extends Model
{
    protected $table = 'tbl_familiares';

    protected $primaryKey = 'id_familiar';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico','numero_personas','numero_personas_trabajando','aportan_dinero_mensual',
    ];
}
