<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VisitaRequest;
use App\Visita;
use App\Pessoa;
use App\Veiculo;

class PortariaCtrl extends Controller
{
  public function __construct(Visita $s,Pessoa $p, Veiculo $v){
    $this->VisitaModel = $s;
    $this->PessoaModel = $p;
    $this->VeiculoModel = $v;
    $this->pagLimit = 10;
    $this->autoCompleteLimit = 5;

  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno =   $this->VisitaModel
      ->whereHas('morador', function($q) use ($filtro){
        $q->where('nome', 'LIKE', "%$filtro%")
        ->orWhere("cpf", "LIKE", "%$filtro%");
      })
      ->orWhereHas('visitante', function($q) use ($filtro){
        $q->where('nome', 'LIKE', "%$filtro%")
        ->orWhere("cpf", "LIKE", "%$filtro%");
      })
      ->orWhereHas('porteiro', function($q) use ($filtro){
        $q->where('nome', 'LIKE', "%$filtro%")
        ->orWhere("cpf", "LIKE", "%$filtro%");
      })
      ->orWhereHas('veiculo', function($q) use ($filtro){
        $q->where('placa', 'LIKE', "%$filtro%");
      })
      ->orderBy('id', 'DESC')
      ->paginate($this->pagLimit);
    }else {
      $retorno =   $this->VisitaModel->orderBy('id', 'DESC')->paginate($this->pagLimit);
    }

    return view('portaria.list',['visitas'=>$retorno]);
  }

  public function store(VisitaRequest $request){

    $visitante = $request->get('visitante');
    $morador = $request->get('morador');
    $veiculo = $request->get('veiculo');

    $morador = $this->PessoaModel->find($morador["id"]);

    if ($morador) {
      //checa visitante ou cadastra.
      if ($visitante["id"]==0) {
        $visitante = $this->PessoaModel->create(['nome'=>$visitante["nome"],'cpf'=>$visitante["cpf"]]);
      }
      else {
        $visitante = $this->PessoaModel->find($visitante["id"]);
      }

      //checa veiculo ou cadastra
      if (!$veiculo["placa"]=="") {

        if ($veiculo["id"]==0) {

          $veiculo  =   $this->VeiculoModel->create(['placa'=>$veiculo["placa"]]);
          $veiculo->utilizadores()->attach($visitante->id);

        }
        else {
          $veiculo = $this->VeiculoModel->find($veiculo["id"]);
          //associa veiculo ao visitante se nao houver.
          if (!$veiculo->utilizadores()->find($visitante->id)) {
            $veiculo->utilizadores()->attach($visitante->id);
          }
        }
      }else {
        $veiculo = null;
      }

      $morador->visitas()->create([
        'porteiro_id'=>auth()->user()->id,
        'visitante_id'=>$visitante->id,
        'veiculo_id'=>  $veiculo !=null ? $veiculo->id : null]
      );

      return response('Registro efetuado', 200);
    }//se nao achar morador nao faz nada.

    return response('Não foi encontrado morador', 404);
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $visita =  $this->VisitaModel->find($id);

    if (!$visita) {
      return redirect('portaria');
    }

    if (auth()->user()->permissao == 'a' || auth()->user()->id == $Portaria->usuario->id) {
      $visita->delete();
      \Session::flash('success_message','Registro excluido!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Você não tem permissão para excluir']);
    }

  }

  private function transform_data($obj){

    //placa
    if (isset($obj["nome"])) {
      return [
        'id'=>$obj['id'],
        'name'=>$obj["nome"]
      ];

    }
    //placa
    return [
      'id'=>$obj['id'],
      'name'=>$obj["placa"]
    ];
  }

  public function getMoradores(Request $request){

    $filtro = $request->exists('busca') ? $request->get('busca') : '';

    $retorno =  $this->PessoaModel->moradores(false)
    ->where("nome", "LIKE", "%$filtro%")
    ->orWhere("rg", "LIKE", "%$filtro%")
    ->orWhere("cpf", "LIKE", "%$filtro%")
    ->orWhere("cnpj", "LIKE", "%$filtro%")
    ->select('id','nome')
    ->limit(50)
    ->get();
  
    $data_transformed =  array_map([$this, 'transform_data'], $retorno->toArray());

    return $data_transformed;
  }

  public function getVisitantes(Request $request){

    $filtro = $request->exists('busca') ? $request->get('busca') : '';

    $retorno = $this->PessoaModel->visitantes()
    ->orderBy('nome', 'ASC')
    ->where("nome", "LIKE", "%$filtro%")
    ->limit(50)
    ->select('id','nome')
    ->get();

    $data_transformed =  array_map([$this, 'transform_data'], $retorno->toArray());

    return $data_transformed;
  }

  public function getPlacas(Request $request){

    $filtro = $request->exists('busca') ? $request->get('busca') : '';

    $retorno = $this->VeiculoModel
    ->orderBy('placa', 'ASC')
    ->where("placa", "LIKE", "%$filtro%")
    ->limit(50)
    ->select('id','placa')
    ->get();

    $data_transformed =  array_map([$this, 'transform_data'], $retorno->toArray());

    return $data_transformed;
  }


}
