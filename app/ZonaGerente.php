<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZonaGerente extends Model
{
    protected $table = 'tbl_zonas_gerentes';
    protected $primaryKey = 'id_zona_gerente';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_zona','id_usuario', 
    ];
}
