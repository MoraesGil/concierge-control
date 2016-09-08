<?php

// Authentication Routes...



Route::get('/login','UsuarioCtrl@login');
Route::post('/login','UsuarioCtrl@postLogin');
Route::get('/logout','UsuarioCtrl@sair');

Route::get('/cep/{id}',function($cep){
  return \Correios::cep($cep);
});


Route::group(['middleware'=>'auth'], function () {
  Route::get('/home','UsuarioCtrl@index');


  Route::get('/morador/{id}/alterarStatus','CondominoCtrl@changeStatus');//func

  Route::get('/moradores','CondominoCtrl@index');//list
  Route::get('/morador/novo','CondominoCtrl@create');//form
  Route::post('/morador/novo','CondominoCtrl@store');//grava
  Route::get('/morador/{id}/editar','CondominoCtrl@edit');//form
  Route::put('/morador/{id}/editar','CondominoCtrl@update');//grava
  Route::get('/morador/{id}/excluir','CondominoCtrl@destroy');//func

  Route::get('/morador/{id}/dependentes','DependenteCtrl@index');//list
  Route::get('/morador/{id}/novo','DependenteCtrl@create');//form
  Route::post('/morador/{id}/novo','DependenteCtrl@store');//func
  Route::get('/morador/{id}/dependentes/{id}/editar','DependenteCtrl@edit');//form
  Route::put('/morador/{id}/dependentes/{id}/editar','DependenteCtrl@update');//func
  Route::get('/morador/{id}/dependentes/{id}/editar','DependenteCtrl@destroy');//func



});
