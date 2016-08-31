<?php

// Authentication Routes...
Route::get('/login','UsuarioCtrl@login');
Route::post('/login','UsuarioCtrl@postLogin');
Route::get('/logout','UsuarioCtrl@sair');


Route::group(['middleware'=>'auth'], function () {
  Route::get('/home','UsuarioCtrl@index');

  Route::get('/moradores','CondominoCtrl@index');//list
  Route::get('/morador/novo','CondominoCtrl@create');//form
  Route::post('/morador/novo','CondominoCtrl@store');//grava
  Route::get('/morador/{id}/editar','CondominoCtrl@edit');//form
  Route::post('/morador/{id}/editar','CondominoCtrl@update');//grava

  Route::post('/morador/{id}/AdicionaDependente','CondominoCtrl@AdicionarDependente');//func
  Route::post('/morador/{id}/RemoverDependente','CondominoCtrl@RemoverDependente');//func

  Route::post('/morador/{id}/statusChange','CondominoCtrl@statusChange');//func


});
