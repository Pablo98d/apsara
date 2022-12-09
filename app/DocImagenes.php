<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocImagenes extends Model
{
    protected $table = 'tbl_se_documentos';

    protected $primaryKey = 'id_documento';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico','tipo_persona','tipo_foto','path_url',
    ];
}




