<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corte_fecha extends Model
{
    protected $table = 'tbl_corte';
    protected $primaryKey = 'id_corte';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_grupo','nombre_dia','hora'
    ];
    
}
