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


 Route::group([
     'middleware' => 'api',
     'prefix' => 'auth'

 ], function () {



    //POST and Get methods for fechas
    Route::get('fechas', 'FechaController@index');
    Route::get('ultimafecha', 'FechaController@getUltimaFecha');
    Route::post('fechas', 'FechaController@store');

    //POST and Get methods for presupuestos
    Route::get('presupuestounidad', 'PresupuestoUnidadController@index');    
    Route::post('presupuestounidad', 'PresupuestoUnidadController@create');


    //POST and Get methods for roles
     Route::get('roles', 'RolController@index');
     Route::post('roles', 'RolController@nuevorol');

    //POST and Get methods for solicitudes
    Route::get('/solicituditems/{id}', 'SolicitudController@solicitudItems');
    Route::get('solicitudes', 'SolicitudController@index');
    Route::post('solicitudes', 'SolicitudController@nuevasolicitud');
    Route::put('solicitudes', 'SolicitudController@update');
    Route::get('solicitudes-aceptadas', 'SolicitudController@solicitudesAceptadas');
    Route::get('solicitudes-rechazadas', 'SolicitudController@solicitudesRechazadas');
    Route::get('solicitudes-pendientes', 'SolicitudController@solicitudesPendientes');


    //POST and Get methods for roles
    Route::get('roles', 'RolController@index');
    Route::post('roles', 'RolController@nuevorol');

    // Rutas items
    Route::get('items', 'ItemController@index');
    Route::post('items', 'ItemController@store');
    Route::put('items/{id}', 'ItemController@update');
    Route::get('items/{id}', 'ItemController@show');
    Route::delete('items/{id}', 'ItemController@destroy');
    // Rutas ItemSuperior
    Route::get('itemSup', 'ItemSuperiorController@index');
    Route::get('itemSupItems/{id}', 'ItemSuperiorController@allItemsOnSup');
    Route::post('itemSup', 'ItemSuperiorController@store');
    // Rutas ItemPres
    Route::get('itemPres', 'ItemPresController@index');
    Route::post('itemPres', 'ItemPresController@store');

     // Rutas unidades
     Route::get('unidades', 'UnidadController@index');
     Route::post('unidades', 'UnidadController@store');
     Route::put('unidades/{id}', 'UnidadController@update');
     Route::get('unidades/{id}', 'UnidadController@show');
     Route::delete('unidades/{id}', 'UnidadController@destroy');
     Route::get('/unidaditemsuper/{id}', 'UnidadController@unidadItemsSuperiores');
     Route::get('unidaditemsuper', 'UnidadController@allUnidadItems');
     Route::get('unidadunica', 'UnidadController@getUnidadByName');


     //Autentica cion de usuarios
     Route::get('users', 'UserController@getusers');
     Route::post('register', 'UserController@register');
     Route::post('login', 'AuthController@login');
     Route::post('logout', 'AuthController@logout');
     Route::post('refresh', 'AuthController@refresh');
     Route::get('me', 'AuthController@me');

 });
