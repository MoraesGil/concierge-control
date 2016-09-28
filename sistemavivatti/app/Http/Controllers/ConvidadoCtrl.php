<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ConvidadoRequest;
use App\Evento;
use Response;

class ConvidadoCtrl extends Controller
{
  public function __construct(Evento $p){
    $this->EventoModel = $p;
    $this->pagLimit = 10;

  }

  public function index($evento_id){

    $evento = $this->EventoModel->find($evento_id);

    if (!$evento) {
      return Response::json(['log'=>'Evento não encontrado'], 404);
    }
    $retorno = $evento->convidados;

    $data_transformed =  array_map([$this, 'transform_data'], $retorno->toArray());

    return Response::json($data_transformed, 200);
  }
 
  private function transform_data($obj){
    return [
      'id'=>$obj['id'],
      'nome'=>$obj["nome"],
      'pessoa_id'=>$obj["pessoa_id"]
    ];
  }

  public function store($evento_id, ConvidadoRequest $request){

    $evento = $this->EventoModel->find($evento_id);

    if (!$evento) {
      return Response::json(['log'=>'Evento não encontrado'], 404);
    }

    $novo = $evento->convidados()->create($request->all());

    return Response::json([
      'log' => 'Convidado adicionado',
      'data' => $novo
    ]);
  }

  public function destroy($evento_id,$convidado_id){

    $evento = $this->EventoModel->find($evento_id);

    if (!$evento) {
      return Response::json(['log'=>'Evento não encontrado'], 404);
    }

    $convidado = $evento->convidados()->find($convidado_id);

    if (!$convidado) {
      return Response::json(['log'=>'Convidado não encontrado'], 404);
    }
    $convidado->delete();

    return Response::json([
      'log' => 'Convidado removido.'
    ], 200);
  }

}
