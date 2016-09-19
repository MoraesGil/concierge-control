<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FuncionarioRequest;
use App\Pessoa;

class FuncionarioCtrl extends Controller
{
  public function __construct(Pessoa $p){
    $this->PessoaModel = $p;
    $this->pagLimit = 10;

  }

  public function index($prestador_id, Request $request){

    $prestador = $this->PessoaModel->prestadores()->find($prestador_id);

    if (!$prestador) {
      return redirect('prestadores');
    }

    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno = $prestador->dependentes()
      ->where("nome", "LIKE", "%$filtro%")
      ->orWhere("cpf", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno = $prestador->dependentes()->paginate($this->pagLimit);
    }

    return view('funcionarios.list',['funcionarios'=>$retorno,'prestador'=>$prestador]);
  }

  public function create($prestador_id){
    $prestador = $this->PessoaModel->prestadores()->find($prestador_id);

    if (!$prestador) {
      return redirect('prestadores');
    }

    return view('funcionarios.form',['prestador'=>$prestador]);
  }

  public function store($prestador_id,FuncionarioRequest $request){
    $prestador = $this->PessoaModel->prestadores()->find($prestador_id);

    if (!$prestador) {
      return redirect('prestadores');
    }

    //grava dados pessoais
    $novo_funcionario = $prestador->dependentes()->create($request->only('nome', 'rg','cpf'));
    //grava contatos pessoais
    $novo_funcionario->contatos()->create($request->only('telefone', 'celular','email'));
    //grava endereco pessoais
    $novo_funcionario->endereco()->create($request->only('logradouro', 'numero','bairro','cidade','cep'));


    \Session::flash('success_message','Prestador de serviço cadastrado!');

    return redirect()->back();
  }

  public function edit($prestador_id,$funcionario_id){

    $prestador = $this->PessoaModel->prestadores()->find($prestador_id);

    if (!$prestador) {
      return redirect('prestadores');
    }

    $funcionario = $prestador->funcionarios()->find($funcionario_id);

    if (!$funcionario) {
      return redirect('prestador/'.$prestador->id.'/funcionarios');
    }

    $data = array(
      'prestador'=>$prestador,
      'funcionario'=>$funcionario

    );

    return view('funcionarios.form',$data);
  }

  public function update($prestador_id,$funcionario_id,FuncionarioRequest $request){

    $prestador = $this->PessoaModel->prestadores()->find($prestador_id);

    if (!$prestador) {
      return redirect('prestadores');
    }

    $funcionario = $prestador->funcionarios()->find($funcionario_id);

    if (!$funcionario) {
      return redirect('prestador/'.$prestador->id.'/funcionarios');
    }

    //atualiza dados pessoais
    $funcionario->update($request->only('nome', 'rg','data_nascimento'));


    \Session::flash('success_message','funcionario atualizado!');

    return redirect()->back();
  }

  public function destroy($prestador_id,$funcionario_id){
    // usuario com pessoa de id = $id
    $prestador = $this->PessoaModel->prestadores()->find($prestador_id);

    if (!$prestador) {
      return redirect('prestadores');
    }
    
    $funcionario = $prestador->dependentes()->find($funcionario_id);

    if (!$funcionario) {
      return redirect('prestador/'.$prestador->id.'/funcionarios');
    }

    $funcionario->delete();

    \Session::flash('success_message','funcionario excluido!');
    return redirect()->back();
  }

}
