<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DependenteRequest;
use App\Pessoa;

class DependenteCtrl extends Controller
{
  public function __construct(Pessoa $p){
    $this->PessoaModel = $p;
    $this->pagLimit = 10;

  }

  public function index($morador_id, Request $request){

    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $filtro = $request->get('busca');
    if ($filtro) {
      $retorno = $morador->dependentes()
      ->where("nome", "LIKE", "%$filtro%")
      ->orWhere("cpf", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno = $morador->dependentes()->paginate($this->pagLimit);
    }

    return view('dependentes.list',['dependentes'=>$retorno,'morador'=>$morador]);
  }

  public function create($morador_id){
    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    return view('dependentes.form',['morador'=>$morador]);
  }

  public function store($morador_id,DependenteRequest $request){
    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    //grava dados pessoais
    $morador->dependentes()->create($request->only('nome', 'rg','data_nascimento'));

    \Session::flash('success_message','Dependente cadastrado!');

    return redirect('morador/'.$morador_id.'/dependente/novo');
  }

  public function edit($morador_id,$dependente_id){

    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $dependente = $morador->dependentes()->find($dependente_id);

    if (!$dependente) {
      return redirect('morador/'.$morador->id.'/dependentes');
    }

    $data = array(
      'morador'=>$morador,
      'dependente'=>$dependente

    );

    return view('dependentes.form',$data);
  }

  public function update($morador_id,$dependente_id,DependenteRequest $request){

    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $dependente = $morador->dependentes()->find($dependente_id);

    if (!$dependente) {
      return redirect('morador/'.$morador->id.'/dependentes');
    }

    //atualiza dados pessoais
    $dependente->update($request->only('nome', 'rg','data_nascimento'));


    \Session::flash('success_message','Dependente atualizado!');
    return redirect('morador/'.$morador->id.'/dependente/'.$dependente->id.'/editar');
  }

  public function destroy($morador_id,$dependente_id){
    // usuario com pessoa de id = $id
    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $dependente = $morador->dependentes()->find($dependente_id);

    if (!$dependente) {
      return redirect('morador/'.$morador->id.'/dependentes');
    }

    $dependente->delete();

    \Session::flash('success_message','Dependente excluido!');
    return redirect('morador/'.$morador_id.'/dependentes');
  }




}
