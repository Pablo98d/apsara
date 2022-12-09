<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GruposPromotoras extends Model
{
    protected $table = 'tbl_grupos_promotoras';
    protected $primaryKey = 'id_grupo_promotoras';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_grupo','id_usuario',
    ];
}
