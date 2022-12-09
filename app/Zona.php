<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'tbl_zona';
    protected $primaryKey = 'IdZona';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IdZona','Zona','Fecha_apertura','IdPlaza'];
    
}