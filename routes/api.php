<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\AuthController;
use App\Http\Controller\UserController;
use App\Http\Controller\RolController;
use App\Http\Controller\ItemController;
use App\Http\Controller\SolicitudController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    









































    





    //POST and Get methods for roles
    Route::get('roles', 'RolController@index');
    Route::post('roles', 'RolController@nuevorol');

    //POST and Get methods for Items
    Route::get('items', 'ItemController@index');
    Route::post('items', 'ItemController@nuevoitem');

    //Autentica cion de usuarios
    Route::get('users', 'UserController@getusers');
    Route::post('register', 'UserController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

