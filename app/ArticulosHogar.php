<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticulosHogar extends Model
{
    protected $table = 'tbl_se_articulos_hogar';

    protected $primaryKey = 'id_articulo';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_socio_economico','estufa','refrigerador','microondas','lavadora','secadora','computadora_escritorio','laptop','television','pantalla','grabadora','estereo','dvd','blue_ray','teatro_casa','bocina_portatil','celular','tablet','consola_videojuegos','instrumentos','otros'
    ];
}
