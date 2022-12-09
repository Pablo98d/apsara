<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipoabono extends Model
{
    protected $table = 'tbl_tipoabono';
    protected $primaryKey = 'id_tipoabono';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipoAbono',
    ];
}
