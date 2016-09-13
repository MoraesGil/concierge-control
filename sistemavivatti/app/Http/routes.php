<?php

// Authentication Routes...



Route::get('/login','UsuarioCtrl@login');
Route::post('/login','UsuarioCtrl@postLogin');
Route::get('/logout','UsuarioCtrl@sair');

Route::get('/cep/{id}',function($cep){
  return \Correios::cep($cep);
});

Route::group(['middleware'=>'auth'], function () {

  // ROTAS MORADOR
  Route::get('/moradores','CondominoCtrl@index');//list
  Route::get('/morador/novo','CondominoCtrl@create');//form
  Route::post('/morador/novo','CondominoCtrl@store');//grava
  Route::get('/morador/{id}/editar','CondominoCtrl@edit');//form
  Route::put('/morador/{id}/editar','CondominoCtrl@update');//grava
  Route::get('/morador/{id}/excluir','CondominoCtrl@destroy');//func
  Route::get('/morador/{id}/alterarStatus','CondominoCtrl@changeStatus');//func
  // ROTAS PORTEIRO
  Route::get('/porteiros','PorteiroCtrl@index');//list
  Route::get('/porteiro/novo','PorteiroCtrl@create');//form
  Route::post('/porteiro/novo','PorteiroCtrl@store');//grava
  Route::get('/porteiro/{id}/editar','PorteiroCtrl@edit');//form
  Route::put('/porteiro/{id}/editar','PorteiroCtrl@update');//grava
  Route::get('/porteiro/{id}/excluir','PorteiroCtrl@destroy');//func
  Route::get('/porteiro/{id}/alterarStatus','PorteiroCtrl@changeStatus');//func

  // ROTAS SINDICO
  Route::get('/sindicos','SindicoCtrl@index');//list
  Route::get('/sindico/novo','SindicoCtrl@create');//form
  Route::post('/sindico/novo','SindicoCtrl@store');//grava
  Route::get('/sindico/{id}/editar','SindicoCtrl@edit');//form
  Route::put('/sindico/{id}/editar','SindicoCtrl@update');//grava
  Route::get('/sindico/{id}/excluir','SindicoCtrl@destroy');//func
  Route::get('/sindico/{id}/alterarStatus','SindicoCtrl@changeStatus');//func

  // ROTAS DEPENDENTES
  Route::get('/morador/{morador_id}/dependentes','DependenteCtrl@index');//list
  Route::get('/morador/{morador_id}/dependente/novo','DependenteCtrl@create');//form
  Route::post('/morador/{morador_id}/dependente/novo','DependenteCtrl@store');//func
  Route::get('/morador/{morador_id}/dependente/{dependente_id}/editar','DependenteCtrl@edit');//form
  Route::put('/morador/{morador_id}/dependente/{dependente_id}/editar','DependenteCtrl@update');//func
  Route::get('/morador/{morador_id}/dependente/{dependente_id}/excluir','DependenteCtrl@destroy');//func

  // ROTAS SERVIÇOS
  Route::get('/servicos','ServicoCtrl@index');//list
  Route::get('/servico/novo','ServicoCtrl@create');//form
  Route::post('/servico/novo','ServicoCtrl@store');//grava
  Route::get('/servico/{id}/editar','ServicoCtrl@edit');//form
  Route::put('/servico/{id}/editar','ServicoCtrl@update');//grava
  Route::get('/servico/{id}/excluir','ServicoCtrl@destroy');//func

  // ROTAS VEICULOS
  Route::get('/veiculos','ServicoCtrl@index');//list
  Route::get('/veiculo/novo','ServicoCtrl@create');//form
  Route::post('/veiculo/novo','ServicoCtrl@store');//grava
  Route::get('/veiculo/{id}/editar','ServicoCtrl@edit');//form
  Route::put('/veiculo/{id}/editar','ServicoCtrl@update');//grava
  Route::get('/veiculo/{id}/excluir','ServicoCtrl@destroy');//func



});
