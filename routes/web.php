<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect('login');
// });
Route::get('/Quienes-Somos', function () {
        return view('publicidad/somos');
});


// Route::get('/','InicioController@index');
// Route::get('/','InicioController@index');
Route::get('/index','InicioController@inicio');
Route::get('/','InicioController@index');

Route::get('/nosotros','InicioController@nosotros');
Route::get('/articulo-1','InicioController@articulo_1');
Route::get('/articulo-2','InicioController@articulo_2');
Route::get('/articulo-3','InicioController@articulo_3');
Route::get('/centro-ayuda','InicioController@centro_ayuda');
Route::get('configuracion-region/{id_region}', 'HomeController@configuracion_region')->name('configuracion_region');
Route::get('configuracion-zona/{id_zona}', 'HomeController@configuracion_zona')->name('configuracion_zona');

Route::get('validacion-sms', 'HomeController@validacion_sms')->name('validacion_sms');
Route::post('enviar-de-nuevo', 'HomeController@enviar_de_nuevo')->name('enviar_de_nuevo');
Route::post('validar-sms', 'HomeController@validar_sms')->name('validar_sms');

Route::get('/corte', 'HomeController@hacer_corte');
Route::get('/corte-edit/{id_corte}', 'HomeController@corte_editar');

Route::post('/corte-store', 'HomeController@corte_store');
Route::post('/corte-update/{id_corte}', 'HomeController@corte_update');
Route::post('/corte-delete/{id_corte}', 'HomeController@corte_delete');
Route::get('/actualizar-fechas-corte', 'HomeController@actualizar_fechas_corte');




Route::get('form-registrar', 'Registro_prospecto@formulario_prospecto');
Route::post('registrar-prospecto', 'Registro_prospecto@guardar_prospecto');

Route::get('logs-feriecita', 'HomeController@logs_feriecita');
Route::get('corte-general', 'HomeController@corte_general');
Route::get('terminar-corte-general', 'HomeController@terminal_corte_general');


// Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Auth::routes();


Route::get('home', 'HomeController@index')->name('home');
Route::get('ubicacion_gerente', 'HomeController@ubicacion_gerente_zona')->name('ubicacion_gerente');
Route::get('buscar_autos', 'HomeController@buscar_autos')->name('buscar_autos');
Route::get('buscar_autos_prueba', 'HomeController@buscar_autos_prueba')->name('buscar_autos_prueba');

Route::get('/estadistica', 'HomeController@vista_estadisticas')->name('estadisticas');
Route::get('pdf_estadisticas_general', 'HomeController@pdf_estadisticas_general')->name('pdf_estadisticas_general');

Route::get('/generar_corte', 'HomeController@hacer_corte')->name('corte');
Route::get('/fecha-de-corte', 'HomeController@fechas_corte')->name('fecha_de_corte');

Route::get('/prueba-de-corte', 'HomeController@prueba_corte_varios_dias')->name('prueba_de_corte');
Route::post('/guardar-multas', 'HomeController@guardar_multas');

Route::get('/corte-mes', 'HomeController@corte_mes');
Route::get('/mapa-de-calor', 'HomeController@mapa_calor');

Route::get('/configurar-corte-semana/{id_region}/{id_zona}/{id_grupo}', 'HomeController@configuracion_corte_semana');
Route::post('/guardar-corte-semana', 'HomeController@guardar_corte_semana');
Route::get('edit-corte-semana/{id_corte}', 'HomeController@edit_corte_semana');
Route::post('update-corte-semana', 'HomeController@update_corte_semana');
Route::post('delete-corte-semana/{id}', 'HomeController@delete_corte_semana');
Route::get('cambiar-corte-abono/{id_corte}', 'HomeController@cambiar_corte_abono');
Route::post('guardar-cambios-fecha-corte', 'HomeController@guardar_cambios_fecha_corte');
Route::post('buscar_fecha_corte', 'HomeController@buscar_fecha_corte');

Route::post('actualizar_datos_corte', 'HomeController@actualizar_datos_corte');

Route::get('admin-carrousel', 'HomeController@admin_carrousel');
Route::post('actualizar-carrousel', 'HomeController@actualizar_carrousel');
Route::get('total-clientes', 'DatosUsuarioController@total_clientes');








Route::get('/estadisticas', 'HomeController@vista_estadisticas')->name('estadisticas_general');
Route::get('/estadistica-zona', 'HomeController@pruebas');
Route::get('/reporte_general_grupo/{id_grupo}', 'HomeController@reportes');




Route::post('/login', ['uses' => 'Auth\LoginController@login', 'before' => 'guest']);
//Desconecta al usuario
Route::get('/logout', ['uses' => 'Auth\LoginController@logout', 'before' => 'auth']);


// todas la rutas
Route::resource('admin/users','AdminUsersController');
Route::post('admin/users/create');
Route::get('admin/prospecto','AdminUsersController@formulario_prospecto')->name('nuevo_prospecto');


Route::resource('prestamo/buscar-cliente/admin/prestamos','PrestamosController');
Route::post('prestamo/buscar-cliente/admin/prestamos/create');



Route::post('actualizar-promotora-prestamos','PrestamosController@actualizar_promotora_de_prestamos')->name('actualizar_promotora_de_prestamos');



Route::post('prestamo/buscar-cliente/admin/prestamos/create');
// 
Route::resource('grupos/grupo/admin/grupos','GruposController');
Route::post('admin/grupos/create');

//
Route::resource('grupos/admin/grupospromotoras','GruposPromotorasController');
Route::post('admin/grupospromotoras/create');
Route::post('buscando_grupos_promotoras','GruposPromotorasController@buscando_grupos_promotoras');
// Route::post('buscando_promotoras','GruposPromotorasController@buscando_promotoras');


// 
Route::resource('admin/rutas','RutasController');
Route::post('admin/rutas/create');

// 
Route::resource('prestamo/socio/admin/socioeconomico','SocioEconomicoController');
Route::get('admin/socioeconomico/registro/cliente','SocioEconomicoController@registro_cliente')->name('registro_cliente');


Route::post('admin/socioeconomico/create');

Route::get('informacion-socioeconomico/{id_socio}','SocioEconomicoController@informacion_socio_pdf');
Route::post('actualizacion-socioeconomico','SocioEconomicoController@actualizacion_socio');

// 
Route::resource('admin/tipousuarios','TipoUsuarioController');
Route::post('actualizar-nombre-tipousuario','TipoUsuarioController@actualizar_nombre');
Route::post('admin/tipousuarios/create');




Route::resource('admin/datosusuario','DatosUsuarioController');
Route::post('admin/datosusuario/create');
Route::post('admin/datosgenerales','DatosUsuarioController@create_datos_generales');
Route::post('admin/datosgenerales-editar/{id}','DatosUsuarioController@update_datos_generales');



Route::resource('admin/abonos','AbonosController');
Route::post('admin/abonos/create');
// 
Route::resource('admin/detalleruta','DetalleRutaController');
Route::post('admin/detalleruta/create');

// 
Route::resource('admin/penalizacion','PenalizacionController');
Route::post('admin/penalizacion/create');

// 
Route::resource('admin/statusprestamo','StatusPrestamoController');
Route::post('admin/statusprestamo/create');

// 
Route::resource('admin/tipovisita','TipoVisitaController');
Route::post('admin/tipovisita/create');

Route::resource('admin/domicilio','DomicilioController');
Route::post('admin/domicilio/create');

Route::resource('admin/articuloshogar','ArticulosHogarController');
Route::post('admin/articuloshogar/create');

// ///////////////////garantias

Route::post('guardar-garantias', 'ArticulosHogarController@guardar_garantias');
Route::post('actualizar-garantia/{id_garantia}', 'ArticulosHogarController@actualizar_garantia');
Route::post('eliminar-garantia', 'ArticulosHogarController@eliminar_garantia');


Route::post('guardar_garantia', 'ArticulosHogarController@guardar_garantia');






// 
Route::resource('admin/aval','AvalController');
Route::post('admin/aval/create');

Route::resource('admin/familiares','FamiliaresController');
Route::post('admin/familiares/create');

Route::resource('admin/fechamonto','FechaMontoController');
Route::post('admin/fechamonto/create');
// 
Route::resource('admin/finanzas','FinanzasController');
Route::post('admin/finanzas/create');

// 
Route::resource('admin/gastosmensuales','GastosMensualesController');
Route::post('admin/gastosmensuales/create');

// 
Route::resource('admin/gastossemanales','GastosSemanalesController');
Route::post('admin/gastossemanales/create');

// 
Route::resource('admin/pareja','ParejaController');
Route::post('admin/pareja/create');

Route::resource('admin/promotora','PromotoraController');
Route::post('admin/promotora/create');

Route::resource('admin/vivienda','ViviendaController');
Route::post('admin/vivienda/create');

Route::resource('admin/productos','ProductosController');
Route::post('admin/productos/create');

// Se usa para buscar productos por peticion en la parte de completar socioeconomicos
Route::post('buscar_producto','ProductosController@buscar_producto')->name('buscar_producto');

Route::resource('admin/referencialaboral','ReferenciaLaboralController');
Route::post('admin/referencialaboral/create');

Route::resource('admin/referencialbpersonas','ReferenciaLaboralPersonasController');
Route::post('admin/referencialbpersonas/create');

Route::resource('admin/referenciapersonal','ReferenciaPersonalController');
Route::post('admin/referenciapersonal/create');

Route::resource('admin/referenciappersonas','ReferenciaPersonalPersonasController');
Route::post('admin/referenciappersonas/create');

Route::resource('miperfil','MiPerfilController');
Route::post('miperfil-actualizar','MiPerfilController@actualizar_foto');
Route::post('miperfil/create');

////-----------------------Diaz--------

Route::resource('grupos/region/admin-region','Admin\PlazaController');
Route::resource('grupos/zona/admin-zona','Admin\ZonaController');
Route::get('grupos/zona/corte_zona/{idregion}/{idzona}','Admin\ZonaController@reporte_corte');
Route::get('grupos/zona/reporte_corte_zona/{idregion}/{idzona}','Admin\ZonaController@reporte_corte_pdf');
Route::get('grupos/zona/pdf_corte_zona/{idregion}/{idzona}/{semana}','Admin\ZonaController@reporte_corte_por_fechas');

Route::get('grupos/zona/corte_zona_semana/{idregion}/{idzona}','Admin\ZonaController@cortes_semanas_pagos');

Route::get('gsinzona','GruposController@sinzona');
Route::post('admin-zona-agrega','GruposController@agregarazona');
Route::get('ver-grupos/{IdZona}','GruposController@filtroporzona');
Route::post('filtro-abonos','AbonosController@filtroabonos')->name('buscar');
Route::post('buscar-prestamo','AbonosController@buscarprestamo')->name('buscarp');

Route::post('guarda-abono','AbonosController@guardaabono')->name('guardaabono');
Route::get('a-buscar-zona','AbonosController@buscar_zona');
Route::get('a-buscar-grupo','AbonosController@buscar_grupo');
Route::post('guarda-ahorro','AbonosController@ahorro');

//buscar cliente

Route::post('buscar_cliente', 'PrestamosController@buscar_cliente');

Route::get('exportar-clientes-activos/{zona}/{grupo}', 'PrestamosController@exportar_clientes_activos');


// prestamos
Route::get('prestamo/buscar_prestamos1','PrestamosController@buscar_zonas');
Route::get('operacion/buscar_prestamos1','PrestamosController@buscar_zonas');
Route::post('buscando_promotora','PrestamosController@buscando_promotoras');
Route::post('pdf_clientes','PrestamosController@pdf_clientes');

Route::post('morosidad','PrestamosController@morosidad_prestamos');

Route::get('operacion/buscar-grupo/{idzona}/{idregion}','PrestamosController@buscar_grupos');
Route::get('prestamo/buscar-grupo/{idzona}/{idregion}','PrestamosController@buscar_grupos');

Route::get('prestamo/buscar-cliente/{idzona}/{idregion}/{idgrupo}','PrestamosController@buscar_clientes');


Route::get('mejor-panorama/{id_region}/{id_zona}','PrestamosController@mejor_panorama');



Route::get('eliminar-sesion','PrestamosController@eliminar');

Route::get('prestamo/abono/agregar-abono-c/{idzona}/{idregion}/{idgrupo}/{id_prestamo}','AbonosController@agregar_abono_c');

Route::get('detalle-prestamo/{id_prestamo}','PrestamosController@detalle_prestamo');

Route::post('renovacion-prestamo','PrestamosController@renovacion');
Route::post('r-prestamo-entrega/{idregion}/{idzona}/{idgrupo}','PrestamosController@r_prestamo_entrega');

// opreaciones

Route::resource('admin-operaciones-prospectos','Admin\OperacionesController');



Route::post('admin-op-pr-zona','Admin\OperacionesController@buscarz')->name('buscarzona');

Route::post('admin-op-pr-grupo','Admin\OperacionesController@buscarg')->name('buscargrupo');

Route::get('operacion/prospecto/admin-operaciones-prospectos/{idregion}/{idzona}/{idgrupo}','Admin\OperacionesController@prospectos_admin');
Route::get('operacion/socio/admin-operaciones-socio_eco/{idregion}/{idzona}/{idgrupo}','Admin\OperacionesController@socio_eco_admin');
Route::get('operacion/admin-operaciones-clientes','Admin\OperacionesController@clientes_operacion');
Route::get('admin-operaciones-detalle/{id_ne}','Admin\OperacionesController@detalle_propuesta');
Route::post('negociacion-guardar','Admin\OperacionesController@guardar_estatus');

Route::get('operacion/opciones-clientes','Admin\OperacionesController@clientes_opciones');


Route::post('aprobacion-socioeconomico','SocioEconomicoController@aprobar_socio');
Route::post('negacion-socioeconomico','SocioEconomicoController@negar_socio');

Route::get('imprimir-pdf','GruposController@pdf')->name('imppdf');

//abonos

Route::get('prestamo/abono/abonos-clientes','AbonosController@abonosclientes');

Route::get('pdf-abono/{idabono}','AbonosController@reciboabono');
Route::get('pdf-abono-semana','AbonosController@pdfabonosemana');

Route::get('pdf-historial-abono/{id_grupo}/{id_abono}','AbonosController@historial_abonos_cliente');

Route::post('abonos-guardar-varios','AbonosController@abonosguardarvarios');


//agrega un gerente a la zona
Route::post('grupos/zona/agregar_gerente_z','Admin\ZonaController@agregar_gerente');
Route::get('show-gerentes-zona/{idzona}','Admin\ZonaController@showgerenteszona');
Route::get('grupos/gerentes/allgerentes','Admin\ZonaController@allgerentesdezona');
Route::get('grupos/gerentes/excluir','Admin\ZonaController@excluir_grupos');
Route::post('guardar-grupos-excluidos','Admin\ZonaController@guardar_grupos_excluidos');
Route::post('guardar-grupos-incluir','Admin\ZonaController@guardar_grupos_inluir');



Route::post('grupos/gerentes/updatezona','Admin\ZonaController@updatezona');
Route::delete('deletezona/{id_zona_gerente}','Admin\ZonaController@deletezona');

//Agregar socioeconomico
Route::get('create-socioeconomico','SocioEconomicoController@crearsocio');
Route::post('finalizacion-socioeconomico','SocioEconomicoController@finalizacion');




//Agregar relacion de aval
Route::post('registrando-aval','AvalController@relacioncrear');
Route::post('actualizando-aval','AvalController@actualizar_aval');

//Filtra nuevos prestamos aprobados y pendientes por entregar
Route::get('prestamo/buscar-cliente/prestamos-nuevos/{idregion}/{idzona}/{idgrupo}','PrestamosController@prestamo_nuevo');
Route::get('pdf-prestamo-nuevo/{idregion}/{idzona}/{idgrupo}','PrestamosController@pdf_reciboprestamos');
Route::get('prestamo/buscar-cliente/prestamos-devolucion/{idregion}/{idzona}/{idgrupo}','PrestamosController@prestamo_devolucion');
Route::get('pdf-prestamo-devolucion/{idregion}/{idzona}/{idgrupo}','PrestamosController@pdf_reciboprestamos_devolucion');
Route::post('devolucion_prestamos','PrestamosController@devolucion_prestamos');


Route::post('update_prestamo_se','PrestamosController@update_prestamo_se');




Route::get('historial-abono/{id_prestamo}','AbonosController@recibo_abono');

// Rutas visita
Route::get('rutas/visitas/visitas-ruta','RutasController@visitas_zona');
Route::post('guardar_visita','RutasController@nueva_visita');
Route::get('rutas/visitas/visitas-porgrupo/{idregion}/{idzona}/{idgrupo}','RutasController@visitas_filtrado');
Route::delete('delete-visita/{id_ruta_zona}','RutasController@deletevisita');
Route::delete('delete-varias-visitas','RutasController@delete_varias_visita');
Route::get('rutas/visitas/update-visitas/{idv}/{idregion}/{idzona}/{idgrupo}','RutasController@edit_visita');
Route::post('rutas/visitas/update-fin-v/{idv}/{idregion}/{idzona}/{idgrupo}','RutasController@update_visita');

Route::get('rutas/visitas/varias-visitas/{idzona}/{idregion}','RutasController@varias_visita_zona');
Route::post('rutas/visitas/varias-visitas-store','RutasController@guardar_varias_visita');

Route::post('guardar-doc-aval','DocImagenesController@guardar_doc_aval');
Route::post('update-doc/{id_doc}','DocImagenesController@update_doc');


//Ultimas rutas
Route::post('liquidacion-renovacion','PrestamosController@liquidacion_renovacion');
Route::post('nuevo_prestamo_extra','PrestamosController@nuevo_prestamo_extra');

Route::post('buscando_producto','PrestamosController@buscando_producto');



Route::get('prestamo/buscar-cliente/prestamos-anticipados/{IdPlaza}/{IdZona}/{id_grupo}','PrestamosController@prestamos_anticipados');
Route::get('pdf-prestamo-anticipado/{idregion}/{idzona}/{idgrupo}','PrestamosController@pdf_reciboprestamos_anticipados');
Route::post('prestamo-entrega-anticipados/{idregion}/{idzona}/{idgrupo}','PrestamosController@entrega_prestamos_anticipados');
















//----------------------Clinte----------------------------
Route::get('datos-usuario', 'cliente\HomeClienteController@datos_usuario');
Route::post('guardar-datos', 'cliente\HomeClienteController@guardar_datos');
Route::post('editar-datos/{id_datos_usuario}', 'cliente\HomeClienteController@editar_datos');



// socioeconomico
Route::get('socio_e_cliente', 'cliente\HomeClienteController@realizar_socio');
Route::post('guardar_socio', 'cliente\HomeClienteController@guardar_socio');
Route::post('familiares_guardar', 'cliente\HomeClienteController@familiares_guardar');
Route::post('familiares_update/{id}', 'cliente\HomeClienteController@familiares_update');
Route::post('aval_guardar', 'cliente\HomeClienteController@aval_guardar');
Route::post('aval_guardar_se', 'cliente\HomeClienteController@aval_guardar_se');
Route::post('aval_update/{id}', 'cliente\HomeClienteController@aval_update');
Route::post('vivienda_guardar', 'cliente\HomeClienteController@vivienda_guardar');
Route::post('vivienda_update/{id}', 'cliente\HomeClienteController@vivienda_update');
Route::post('pareja_guardar', 'cliente\HomeClienteController@pareja_guardar');
Route::post('pareja_update/{id}', 'cliente\HomeClienteController@pareja_update');
Route::post('domicilio_guardar', 'cliente\HomeClienteController@domicilio_guardar');
Route::post('domicilio_update/{id}', 'cliente\HomeClienteController@domicilio_update');
Route::post('art_hogar_guardar', 'cliente\HomeClienteController@art_hogar_guardar');
Route::post('art_hogar_update/{id}', 'cliente\HomeClienteController@art_hogar_update');
Route::post('finanzas_guardar', 'cliente\HomeClienteController@finanzas_guardar');
Route::post('finanzas_update/{id}', 'cliente\HomeClienteController@finanzas_update');
Route::post('fecha_m_guardar', 'cliente\HomeClienteController@fecha_m_guardar');
Route::post('fecha_m_update/{id}', 'cliente\HomeClienteController@fecha_m_update');
Route::post('g_mensuales_guardar', 'cliente\HomeClienteController@g_mensuales_guardar');
Route::post('g_mensual_update/{id}', 'cliente\HomeClienteController@g_mensual_update');
Route::post('g_semanal_guardar', 'cliente\HomeClienteController@g_semanal_guardar');
Route::post('g_semanal_update/{id}', 'cliente\HomeClienteController@g_semanal_update');
Route::post('r_laboral_guardar', 'cliente\HomeClienteController@r_laboral_guardar');
Route::post('r_l_presonas_update/{id}', 'cliente\HomeClienteController@r_l_presonas_update');
Route::post('r_personal_guardar', 'cliente\HomeClienteController@r_personal_guardar');
Route::post('r_personal_update/{id}', 'cliente\HomeClienteController@r_personal_update');
Route::post('c_finalizacion', 'cliente\HomeClienteController@c_finalizacion');

Route::get('prestamo_cliente', 'cliente\HomeClienteController@prestamo_cliente');
Route::get('historial_cliente', 'cliente\HomeClienteController@historial_cliente');
Route::get('historial_abono/{id_prestamo}', 'cliente\HomeClienteController@historial_abono');

Route::post('guardar-datos-generales', 'cliente\HomeClienteController@create_datos_generales');
Route::post('actualizar-datos-generales/{id_datos_generales}', 'cliente\HomeClienteController@update_datos_generales');

Route::post('guardar-documento', 'cliente\HomeClienteController@guardar_doc_aval');
Route::post('actualizar-documento/{id_doc}', 'cliente\HomeClienteController@update_doc');








// borrar caché de la aplicación
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

 // borrar caché de ruta
 Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});

// borrar caché de configuración
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
}); 

// borrar caché de vista
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

// Route::get('/home-analista', 'analista\HomeAnalistaController@index')->name('homeanalista');

//rutas clientes
Route::get('/homecliente', 'cliente\HomeClienteController@index')->name('homecliente');
Route::get('cliente-pdf-abono/{id_prestamo}','cliente\HomeClienteController@recibo_abono');
Route::get('/home-analista', 'analista\HomeAnalistaController@index')->name('homeanalista');
Route::get('analisis-socio-economico/{idgrupo}', 'analista\HomeAnalistaController@socio_eco_analista');
Route::get('crear-socioeco-analista','analista\HomeAnalistaController@crear_socio_eco');
Route::post('analista-aprobar-socio','analista\HomeAnalistaController@aprobar_socio');
Route::post('analista-negar-socio','analista\HomeAnalistaController@negar_socio');
Route::get('analista-mi-perfil','analista\HomeAnalistaController@mi_perfil');



Route::get('socio-pendientes-analista/{idgrupo}','analista\HomeAnalistaController@socio_pendientes');
Route::get('socio-aprobados-analista/{idgrupo}','analista\HomeAnalistaController@socio_aprobados');
Route::get('socio-negados-analista/{idgrupo}','analista\HomeAnalistaController@socio_negados');


Route::get('exportar','HomeController@exportar');









