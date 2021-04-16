<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\AuthController;
use App\Http\Controller\UserController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    
    //Autenticacion de usuarios

    
    Route::post('register', 'UserController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

