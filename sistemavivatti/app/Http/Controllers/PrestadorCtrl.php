<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PrestadorRequest;
use App\Pessoa;
use App\Servico;

class PrestadorCtrl extends Controller
{
  public function __construct(Pessoa $p, Servico $s){
    $this->PessoaModel = $p;
    $this->ServicoModel = $s;
    $this->pagLimit = 7;
  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno = $this->PessoaModel->prestadores()
      ->where("nome", "LIKE", "%$filtro%")
      ->orWhere("cpf", "LIKE", "%$filtro%")
      ->orWhere("cnpj", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno = $this->PessoaModel->prestadores()->paginate($this->pagLimit);
    }

    return view('prestadores.list',['prestadores'=>$retorno]);
  }


  public function create(){
    return view('prestadores.form',['servicos'=>$this->ServicoModel->lists('nome','id')]);
  }

  public function store(PrestadorRequest $request){
    //grava dados pessoais
    $novo_prestador = $this->PessoaModel->create($request->only('nome', 'rg','cpf','cnpj'));
    //grava contatos pessoais
    $novo_prestador->contatos()->create($request->only('telefone', 'celular','email'));
    //grava endereco pessoais
    $novo_prestador->endereco()->create($request->only('logradouro', 'numero','bairro','cidade','cep'));

    $novo_prestador->servicos_prestados()->sync($request->get('servicos_id'));

    \Session::flash('success_message','Prestador de serviço cadastrado!');

    return redirect()->back();
  }

  public function edit($id){

    $prestador = $this->PessoaModel->prestadores()->find($id);

    if (!$prestador) {
      return redirect('prestadores');
    }

    $data = array(
      'prestador'=>$this->transform_pessoa($prestador),
      'servicos'=>$this->ServicoModel->lists('nome','id')
    );

    return view('prestadores.form',$data);
  }


  public function update(PrestadorRequest $request, $id){

    $prestador = $this->PessoaModel->prestadores()->find($id);
    if (!$prestador) {
      return redirect('prestadores');
    }

    //atualiza dados pessoais
    $prestador->update($request->only('nome', 'rg','cpf'));
    //atualiza contatos pessoais
    $prestador->contatos()->update($request->only('telefone', 'celular','email'));
    //atualiza endereco pessoais
    $prestador->endereco()->update($request->only('logradouro', 'numero','bairro','cidade','cep','condominio_id'));

    $prestador->servicos_prestados()->sync($request->get('servicos_id'));

    \Session::flash('success_message','prestador atualizado!');
    return redirect()->back();
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $prestador =  $this->PessoaModel->find($id);
    if (!$prestador) {
      return redirect('prestadores');
    }

    $prestador->delete();
    \Session::flash('success_message','Prestador excluido!');
    return redirect()->back();
  }

  public function getNota($prestador_id){
    $prestador =  $this->PessoaModel->find($prestador_id);

    return [
      'id'=>$prestador->id,
      'nome'=>$prestador->nome,
      'nota'=>$prestador->getNotaUsuario(auth()->user()->id)
    ];
  }

  public function putNota(Request $r, $prestador_id){
    $prestador =  $this->PessoaModel->find($prestador_id);
    $usuario_id = auth()->user()->id;

    if ($prestador->getNotaUsuario($usuario_id)>0) {
      //update
      return $prestador->avaliacoes()->updateExistingPivot($usuario_id,['nota'=>$r->get('nota')]);
    }
    else {
      //first
      return $prestador->avaliacoes()->attach($usuario_id,['nota'=>$r->get('nota')]);
    }
  }

  private function transform_pessoa($pessoa){
    $pessoa_retorno = (object) [];
    $pessoa_retorno->id = $pessoa->id;
    $pessoa_retorno->nome = $pessoa->nome;
    $pessoa_retorno->rg = $pessoa->rg;
    $pessoa_retorno->cpf = $pessoa->cpf;
    $pessoa_retorno->telefone = $pessoa->contatos->telefone;
    $pessoa_retorno->celular = $pessoa->contatos->celular;
    $pessoa_retorno->email = $pessoa->contatos->email;
    $pessoa_retorno->cep = $pessoa->endereco->cep;
    $pessoa_retorno->logradouro = $pessoa->endereco->logradouro;
    $pessoa_retorno->numero = $pessoa->endereco->numero;
    $pessoa_retorno->bairro = $pessoa->endereco->bairro;
    $pessoa_retorno->cidade = $pessoa->endereco->cidade;
    $pessoa_retorno->servicos_id = $pessoa->servicos_prestados->pluck('id');


    return $pessoa_retorno;
  }



}
