<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVisita extends Model
{
    protected $table = 'tbl_tipo_visita';
    protected $primaryKey = 'id_tipo_visita';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_visita',
    ];
}
