<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FornecedorRequest;
use App\Pessoa;

class FornecedorCtrl extends Controller
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
      $retorno = $morador->Fornecedors()
      ->where("nome", "LIKE", "%$filtro%")
      ->orWhere("cpf", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno = $morador->Fornecedors()->paginate($this->pagLimit);
    }

    return view('fornecedors.list',['fornecedors'=>$retorno,'morador'=>$morador]);
  }

  public function create($morador_id){
    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    return view('fornecedors.form',['morador'=>$morador]);
  }

  public function store($morador_id,fornecedorRequest $request){
    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    //grava dados pessoais
    $morador->fornecedors()->create($request->only('nome', 'rg','data_nascimento'));

    \Session::flash('success_message','fornecedor cadastrado!');

    return redirect('morador/'.$morador_id.'/fornecedor/novo');
  }

  public function edit($morador_id,$fornecedor_id){

    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $fornecedor = $morador->fornecedors()->find($fornecedor_id);

    if (!$fornecedor) {
      return redirect('morador/'.$morador->id.'/fornecedors');
    }

    $data = array(
      'morador'=>$morador,
      'fornecedor'=>$fornecedor

    );

    return view('fornecedors.form',$data);
  }

  public function update($morador_id,$fornecedor_id,fornecedorRequest $request){

    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $fornecedor = $morador->fornecedors()->find($fornecedor_id);

    if (!$fornecedor) {
      return redirect('morador/'.$morador->id.'/fornecedors');
    }

    //atualiza dados pessoais
    $fornecedor->update($request->only('nome', 'rg','data_nascimento'));


    \Session::flash('success_message','fornecedor atualizado!');
    return redirect('morador/'.$morador->id.'/fornecedor/'.$fornecedor->id.'/editar');
  }

  public function destroy($morador_id,$fornecedor_id){
    // usuario com pessoa de id = $id
    $morador = $this->PessoaModel->moradores()->find($morador_id);

    if (!$morador) {
      return redirect('moradores');
    }

    $fornecedor = $morador->fornecedors()->find($fornecedor_id);

    if (!$fornecedor) {
      return redirect('morador/'.$morador->id.'/fornecedors');
    }

    $fornecedor->delete();

    \Session::flash('success_message','fornecedor excluido!');
    return redirect('morador/'.$morador_id.'/fornecedors');
  }




}
