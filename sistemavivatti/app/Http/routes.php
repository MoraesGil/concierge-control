<?php

// Authentication Routes...



Route::get('/login','UsuarioCtrl@login');
Route::post('/login','UsuarioCtrl@postLogin');
Route::get('/logout','UsuarioCtrl@sair');

Route::get('/','UsuarioCtrl@login');

Route::get('/cep/{id}',function($cep){
  return \Correios::cep($cep);
});

Route::get('mail',function(){
  // return view('email');
  // dd(Config::get('mail'));
  return 'naooo';
});


Route::group(['middleware'=>'auth'], function () {
  // ROTAS HOME
  Route::get('/home','UsuarioCtrl@home');

  // ROTAS MORADOR
  Route::get('/moradores','CondominoCtrl@index');//list
  Route::get('/morador/novo','CondominoCtrl@create');//form
  Route::post('/morador/novo','CondominoCtrl@store');//grava
  Route::get('/morador/{id}/editar','CondominoCtrl@edit');//form
  Route::put('/morador/{id}/editar','CondominoCtrl@update');//grava
  Route::get('/morador/{id}/excluir','CondominoCtrl@destroy');//func
  Route::get('/morador/{id}/alterarStatus','CondominoCtrl@changeStatus');//func

  // ROTAS MORADOR CONTRATOS
  Route::get('/morador/{morador_id}/contratos','CondominoCtrl@index');//list
  Route::post('/morador/{morador_id}/contrato/novo','CondominoCtrl@store');//func
  Route::delete('/morador/{morador_id}/contrato/{cocontrato_id}/excluir','CondominoCtrl@destroy');//func


  // ROTAS DEPENDENTES
  Route::get('/morador/{morador_id}/dependentes','DependenteCtrl@index');//list
  Route::get('/morador/{morador_id}/dependente/novo','DependenteCtrl@create');//form
  Route::post('/morador/{morador_id}/dependente/novo','DependenteCtrl@store');//func
  Route::get('/morador/{morador_id}/dependente/{dependente_id}/editar','DependenteCtrl@edit');//form
  Route::put('/morador/{morador_id}/dependente/{dependente_id}/editar','DependenteCtrl@update');//func
  Route::get('/morador/{morador_id}/dependente/{dependente_id}/excluir','DependenteCtrl@destroy');//func

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

  // ROTAS PRESTADOR
  Route::get('/prestadores','PrestadorCtrl@index');//list
  Route::get('/prestador/novo','PrestadorCtrl@create');//form
  Route::post('/prestador/novo','PrestadorCtrl@store');//grava
  Route::get('/prestador/{id}','PrestadorCtrl@show');//form
  Route::get('/prestador/{id}/editar','PrestadorCtrl@edit');//form
  Route::put('/prestador/{id}/editar','PrestadorCtrl@update');//grava
  Route::get('/prestador/{id}/excluir','PrestadorCtrl@destroy');//func

  Route::get('/prestador/{id}/nota','PrestadorCtrl@getNota');//func
  Route::put('/prestador/{id}/nota','PrestadorCtrl@putNota');//grava

  // ROTAS FUNCIONARIOS PRESTADOR
  Route::get('/prestador/{prestador_id}/funcionarios','FuncionarioCtrl@index');//list
  Route::get('/prestador/{prestador_id}/funcionario/novo','FuncionarioCtrl@create');//form
  Route::post('/prestador/{prestador_id}/funcionario/novo','FuncionarioCtrl@store');//func
  Route::get('/prestador/{prestador_id}/funcionario/{funcionario_id}/editar','FuncionarioCtrl@edit');//form
  Route::put('/prestador/{prestador_id}/funcionario/{funcionario_id}/editar','FuncionarioCtrl@update');//func
  Route::get('/prestador/{prestador_id}/funcionario/{funcionario_id}/excluir','FuncionarioCtrl@destroy');//func

  // ROTAS SERVIÇOS
  Route::get('/servicos','ServicoCtrl@index');//list
  Route::get('/servico/novo','ServicoCtrl@create');//form
  Route::post('/servico/novo','ServicoCtrl@store');//grava
  Route::get('/servico/{id}/editar','ServicoCtrl@edit');//form
  Route::put('/servico/{id}/editar','ServicoCtrl@update');//grava
  Route::get('/servico/{id}/excluir','ServicoCtrl@destroy');//func

  // ROTAS VEICULOS
  Route::get('/veiculos','VeiculoCtrl@index');//list
  Route::get('/veiculo/novo','VeiculoCtrl@create');//form
  Route::post('/veiculo/novo','VeiculoCtrl@store');//grava
  Route::get('/veiculo/{id}/editar','VeiculoCtrl@edit');//form
  Route::put('/veiculo/{id}/editar','VeiculoCtrl@update');//grava
  Route::get('/veiculo/{id}/excluir','VeiculoCtrl@destroy');//func

  // ROTAS Solicitacoes
  Route::get('/solicitacoes','SolicitacaoCtrl@index');//list
  Route::get('/solicitacao/novo','SolicitacaoCtrl@create');//form
  Route::post('/solicitacao/novo','SolicitacaoCtrl@store');//grava
  Route::get('/solicitacao/{id}/editar','SolicitacaoCtrl@edit');//form
  Route::put('/solicitacao/{id}/editar','SolicitacaoCtrl@update');//grava
  Route::get('/solicitacao/{id}/excluir','SolicitacaoCtrl@destroy');//func
  Route::get('/solicitacao/{id}/finalizar','SolicitacaoCtrl@finalizar');//func

  // ROTAS recados
  Route::get('/recados','RecadoCtrl@index');//list
  Route::post('/recado/novo','RecadoCtrl@store');//grava
  Route::get('/recado/{id}/excluir','RecadoCtrl@destroy');//func

  // ROTAS Eventos
  Route::get('/eventos','EventoCtrl@index');//list
  Route::get('/evento/novo','EventoCtrl@create');//form
  Route::post('/evento/novo','EventoCtrl@store');//grava
  Route::get('/evento/{id}/editar','EventoCtrl@edit');//form
  Route::put('/evento/{id}/editar','EventoCtrl@update');//grava
  Route::get('/evento/{id}/excluir','EventoCtrl@destroy');//func
  Route::get('/evento/getvisitantes','EventoCtrl@getVisitantes');//list

  // ROTAS Convidados evento
  Route::get('/evento/{evento_id}/convidados','ConvidadoCtrl@index');//list
  Route::post('/evento/{evento_id}/convidado/novo','ConvidadoCtrl@store');//func
  Route::delete('/evento/{evento_id}/convidado/{convidado_id}/excluir','ConvidadoCtrl@destroy');//func

  // ROTAS LIVRO PORTARIA
  Route::get('/portaria','PortariaCtrl@index');//list
  Route::post('/visita/novo','PortariaCtrl@store');//grava
  Route::get('/visita/{id}/excluir','PortariaCtrl@destroy');//func

  Route::get('/portaria/getmoradores','PortariaCtrl@getMoradores');//list
  Route::get('/portaria/getplacas','PortariaCtrl@getPlacas');//list
  Route::get('/portaria/getvisitantes','PortariaCtrl@getVisitantes');//list

});
