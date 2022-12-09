<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Abonos;
use App\Grupos;
use App\User;
use App\Plaza;
use App\Zona;
use App\Tipoabono;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class AbonosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function historial_abono($idgrupo,$id_abono){


        $region_zona = DB::table('tbl_plaza')
            ->Join('tbl_zona', 'tbl_plaza.IdPlaza', '=', 'tbl_zona.IdPlaza')
            ->Join('tbl_grupos', 'tbl_zona.IdZona', '=', 'tbl_grupos.IdZona')
            
            ->select('tbl_plaza.*','tbl_zona.*','tbl_grupos.*')
            ->where('tbl_grupos.id_grupo','=',$idgrupo)
            ->get();
            // dd($region_zona);

        $prestamo = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.status_prestamo')
        ->where('tbl_abonos.id_abono','=',$id_abono)
        ->get();

        $cliente = DB::table('tbl_usuarios')
            ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
            ->select('tbl_usuarios.*','tbl_datos_usuario.*')
            ->where('tbl_abonos.id_abono','=',$id_abono)
            // ->distinct()
            ->get();

        $aval = DB::table('tbl_socio_economico')
            ->Join('tbl_prestamos', 'tbl_socio_economico.id_usuario', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_se_aval', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_aval.id_socio_economico')
            ->Join('tbl_avales', 'tbl_se_aval.id_aval', '=', 'tbl_avales.id_aval')
            ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
            ->select('tbl_avales.*')
            ->where('tbl_abonos.id_abono','=',$id_abono)
            ->distinct()
            ->get();

        $datosabonos=DB::table('tbl_abonos')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono')
        ->where('id_prestamo', '=', $prestamo[0]->id_prestamo)
        ->orderBy('tbl_abonos.semana','ASC')
        ->get();

        $pdf = PDF::loadView('api.historial_abono',['region_zona'=>$region_zona,'cliente'=>$cliente,'datosabonos'=>$datosabonos,'prestamo'=>$prestamo,'aval'=>$aval]);

        // $pdf = PDF::loadView('admin.abonos.pdf_abono',['datoscliente'=>$datoscliente,'abonos'=>$abonos]);
        return $pdf->stream();

    }
}