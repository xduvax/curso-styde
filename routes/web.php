<?php

Route::get('/', function () {
    return view('inicio');
});

Route::get('/usuarios', 'UserController@list');

Route::get('/usuarios/{usuario}', 'UserController@detail')->where('usuario', '[0-9]+');

Route::get('/usuarios/nuevo', 'UserController@new');

Route::get('/usuarios/{usuario}/editar', 'UserController@edit');

Route::post('/usuarios/guardar', 'UserController@store');

Route::put('/usuarios/{usuario}', 'UserController@update');

Route::delete('/usuarios/{usuario}', 'UserController@delete');
