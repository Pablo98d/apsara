<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plaza extends Model
{
    protected $table = 'tbl_plaza';
    protected $primaryKey = 'IdPlaza';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IdPlaza','Plaza','Fecha_apertura'];
    
}