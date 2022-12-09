<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    protected $table = 'tbl_grupos';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grupo','localidad','municipio','estado','IdZona'
    ];
    
}
