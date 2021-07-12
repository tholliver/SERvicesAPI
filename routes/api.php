<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\AuthController;
use App\Http\Controller\UserController;
use App\Http\Controller\RolController;
use App\Http\Controller\ItemController;
use App\Http\Controller\ItemPresController;
use App\Http\Controller\UnidadController;
use App\Http\Controller\SolicitudController;
use App\Http\Controller\FechaController;
use App\Http\Controller\PresupuestoUnidadController;
use App\Http\Controller\EmpresaCotizController;
use App\Http\Controller\EmpresaController;
use App\Http\Controller\FacultadController;
use App\Http\Controller\ItemCotController;
use App\Http\Controller\ScanCotizacionController;
use App\Http\Controller\InformeController;
use App\Http\Controller\ActivityLogController;
use App\Http\Controllers\BackupController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {


    //POST and Get methods for fechas
    Route::get('fechas', 'FechaController@index');
    Route::get('ultimafecha', 'FechaController@getUltimaFecha');
    Route::post('fechas', 'FechaController@store');

    //POST and Get methods for empresas
    Route::get('empresas', 'EmpresaController@index');
    ////////////////////////////////////////////////
    Route::get('verificarEmpresa/{nombre}', 'EmpresaController@verificar');
    Route::get('/empresas/{id}', 'EmpresaController@show');
    Route::get('/empresasInfo/{id}', 'EmpresaController@empresInfo');
    Route::post('empresas', 'EmpresaController@store');
    Route::post('empresas/{id}', 'EmpresaController@update');
    Route::delete('empresas/{id}', 'EmpresaController@destroy');


    //POST and Get methods for presupuestos
    Route::get('presupuesto', 'PresupuestoUnidadController@index');
    Route::get('presupuestos', 'PresupuestoUnidadController@getDatos');
    Route::get('presupuesto/{id}/{gestion}', 'PresupuestoUnidadController@presupuestoId');
    Route::post('presupuesto', 'PresupuestoUnidadController@nuevoPresupuesto');
    Route::put('presupuesto', 'PresupuestoUnidadController@update');
    Route::delete('presupuesto/{id}', 'PresupuestoUnidadController@destroy');


    //POST and Get methods for roles
     Route::get('roles', 'RolController@index');
     ///////////////////////////////////////
     Route::get('rolesVerificar/{denominativo}', 'RolController@verificar');
     Route::get('roles2', 'RolController@index2');
     Route::post('roles', 'RolController@nuevorol');
     Route::get('rol-privilegios/{nombre}', 'RolController@getPrivilegios');
     //POST and Get methods for empresaCotizacion
      Route::get('empresaCot', 'EmpresaCotizController@index');
      Route::post('empresaCot', 'EmpresaCotizController@store');
      ///////////////////////////////////////////
      Route::post('empresaCot/{id}', 'EmpresaCotizController@update');

      Route::put('actualizar-recomendar', 'EmpresaCotizController@recomendacionUpdate');

    //empresaCotizacion
    Route::get('/empresa-cotizacion/{id}', 'EmpresaCotizController@empresaCotizacion');
    Route::get('/solicitud-cotizacion-items/{id}', 'EmpresaCotizController@cotizacionItems');
    //probandos
    Route::get('/cotizacion/{id1}/{id2}', 'EmpresaCotizController@obtenerCotizacion');
    Route::get('/nombreEmp/{id}', 'EmpresaCotizController@obtenerEmpresas');



    //POST and Get methods for solicitudes
    Route::get('/solicituditems/{id}', 'SolicitudController@solicitudItems');
    Route::get('/solicituditemspivot', 'SolicitudController@solicitudItemsPivot');

    Route::get('solicitudes', 'SolicitudController@index');
    Route::get('/solicituditems2/{id}', 'SolicitudController@solicitudItems2');
    Route::get('/solicitud3/{id}', 'SolicitudController@solicitud3');
    Route::post('solicitudes', 'SolicitudController@nuevasolicitud');

    Route::put('solicitudes', 'SolicitudController@update');
    Route::put('solicitudes11', 'SolicitudController@update1');
    Route::get('solicitudes-aceptadas', 'SolicitudController@solicitudesAceptadas');
    Route::get('solicitudes-rechazadas', 'SolicitudController@solicitudesRechazadas');
    Route::get('solicitudes-pendientes', 'SolicitudController@solicitudesPendientes');


    //POST and Get methods for roles
    Route::get('roles', 'RolController@index');
    Route::post('roles', 'RolController@nuevorol');
    Route::put('roles', 'RolController@update');
    Route::delete('roles/{id}', 'RolController@destroy');

    // Rutas items
    Route::get('items', 'ItemController@index');
    /////////////////////////////////////////////////
    Route::get('verificarItem/{nombre}', 'ItemController@verificar');
    Route::post('items', 'ItemController@store');
    Route::post('items/{id}', 'ItemController@update');
    Route::get('items/{id}', 'ItemController@show');
    Route::delete('items/{id}', 'ItemController@destroy');
    // Rutas ItemSuperior
    Route::get('itemSup', 'ItemSuperiorController@index');
    ///////////////////////////////////////////////////////
    Route::get('itemSuperiorVerificar/{nombre}', 'ItemSuperiorController@verificar');
    Route::get('itemSupItems/{id}', 'ItemSuperiorController@allItemsOnSup');
    Route::get('itemSup/{id}', 'ItemSuperiorController@show');
    Route::post('itemSup', 'ItemSuperiorController@store');
    Route::post('itemSup/{id}', 'ItemSuperiorController@update');
    Route::delete('itemSup/{id}', 'ItemSuperiorController@destroy');
    //destroy($id)
     // Rutas unidades
    Route::get('unidades', 'UnidadController@index');
    /////////////////////////////////////////////////
    Route::get('verificarUnidad/{nombre}', 'UnidadController@verificar');
    Route::post('unidades', 'UnidadController@store');
    Route::post('unidades/{id}', 'UnidadController@update');
    Route::get('unidades/{id}', 'UnidadController@show');
    Route::get('unidades2/{id}', 'UnidadController@show2');
    Route::delete('unidades/{id}', 'UnidadController@destroy');
    //Obtener todas las asignaciones de la unidad --> HISTORIAL
    Route::get('/unidaditemsuper/{id}', 'UnidadController@unidadItemsSuperiores');
    //Obtener todas las asignaciones de la unidad --> Del año en curso
    Route::get('/unidaditemsuper-actual/{id}', 'UnidadController@unidadItemsSuperioresActuales');
    Route::get('unidaditemsuper', 'UnidadController@allUnidadItems');
    Route::get('unidadunica', 'UnidadController@getUnidadByName');


     //Autentica cion de usuarios
    Route::get('users', 'UserController@getusers');
    /////////////////////////////////////////////////
    Route::get('verificar/{nombre}/{apellido}', 'UserController@verificar');
    Route::post('register', 'UserController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::get('auth-user', 'UserController@getAuthenticatedUser');
    Route::put('actualizar', 'UserController@update');
    Route::delete('user/{id}', 'UserController@destroy');

         // Rutas Item Cotizacion
    Route::get('item_cotizacion', 'ItemCotController@index');
    Route::delete('item_cotizacion/{id}', 'ItemCotController@delete');
    Route::post('item_cotizacion', 'ItemCotController@store');
    // subir archivo cotizacion
    Route::get('scan_cotizacion', 'ScanCotizacionController@index');
    Route::post('scan_cotizacion', 'ScanCotizacionController@store');

    Route::post('itemPres', 'ItemPresController@store');
    //unidad y periodo
    Route::get('/itemPresUni/{id1}/{id2}', 'ItemPresController@obtenerPresItem');
    Route::get('/itemPresUniSum/{id1}/{id2}', 'ItemPresController@obtenerPresItemSum');
    Route::get('/itemPresAnio/{id1}', 'ItemPresController@obtenerAnios');
      Route::get('/itemPresAnio1/{id1}', 'ItemPresController@obtenerAnios1');
    Route::delete('itemPresUni/{id}', 'ItemPresController@destroy');

    //Routes for informe
    Route::post('informe', 'InformeController@store');
    Route::get('informe-solicitud/{id}', 'InformeController@getOneInforme');
    Route::get('informes-solicitud', 'InformeController@getAllInformes');


    //Rutas para actividades
    Route::get('logs', 'ActivityLogController@index');
    Route::get('logs-filtered', 'ActivityLogController@filteredLogs');
    Route::get('logs-solicitudes', 'ActivityLogController@getSolicitudes');
    Route::get('logs-cotizaciones', 'ActivityLogController@getCotizaciones');

    Route::get('informe-logs', 'ActivityLogController@getInformes');
    Route::get('stats', 'ActivityLogController@getStats');

    /*Backs */
    Route::get('get-backs','BackupController@getBacks');
    Route::post('setbackup','BackupController@newBack');
    Route::post('restore','BackupController@testFunc');
    //testFunc
    //Agregando Facultad
      Route::get('facultades', 'FacultadController@getFacultades');
      ////////////////////////////////////////////////
      Route::get('verificarFacultad/{nombre}', 'FacultadController@verificar');
      Route::post('facultad', 'FacultadController@register');
      Route::delete('facultad/{id}', 'FacultadController@destroy');
      //////////////////////////////////
      Route::post('facultadAct', 'FacultadController@update');
      /////////////////
      Route::get('/facultadInfo/{id}', 'FacultadController@show');
});
