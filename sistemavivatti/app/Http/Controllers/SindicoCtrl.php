<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SindicoRequest;
use App\Pessoa;
use App\Usuario;
use App\Condominio;

class SindicoCtrl extends Controller
{
  public function __construct(Pessoa $p, Condominio $c, Usuario $u){
    $this->PessoaModel = $p;
    $this->CondominioModel = $c;
    $this->UsuarioModel = $u;
    $this->pagLimit = 7;

    if (auth()->user()->permissao != 'a') {
      \Redirect::to('home')->send();
    } 
  }

  public function index(Request $request){

    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno = $this->PessoaModel->sindicos()
      ->where("nome", "LIKE", "%$filtro%")
      ->orWhere("cpf", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno = $this->PessoaModel->sindicos()->paginate($this->pagLimit);
    }
    return view('sindicos.list',['sindicos'=>$retorno]);
  }


  public function create(){
    return view('sindicos.form',['condominios'=>$this->CondominioModel->lists('nome','id')]);
  }

  public function store(SindicoRequest $request){

    $cpf3 = substr($request->get('cpf'), 0, 3);//3 primeiros digitos cpf

    $login = substr(str_replace(' ', '', $request->get('nome')), 0, 5);//nome 5 primeiras letras

    $login .= $cpf3;
    $senha = 'nova'.$cpf3;
    $senha =  \Hash::make($senha); //criptografia

    //cria usuario
    $novo_usuario = $this->UsuarioModel->create([
      'permissao'=>'p', 'login'=>strtolower($login), 'senha'=>$senha
    ]);

    //grava dados pessoais
    $novo_usuario->dados_pessoais()->create($request->only('nome', 'rg','cpf'));
    //grava contatos pessoais
    $novo_usuario->dados_pessoais->contatos()->create($request->only('telefone', 'celular'));

    //grava endereco pessoais
    $novo_usuario->dados_pessoais->endereco()->create($request->only('logradouro', 'numero','bairro','cidade','cep','condominio_id'));


    \Session::flash('success_message','sindico cadastrado!');

    return redirect()->back();
  }

  public function edit($id){

    $sindico = $this->PessoaModel->sindicos()->find($id);

    if (!$sindico) {
      return redirect('sindicos');
    }

    $data = array(
      'sindico'=>$this->transform_pessoa($sindico),
      'condominios'=>$this->CondominioModel->lists('nome','id')
    );
    return view('sindicos.form',$data);
  }

  private function transform_pessoa($pessoa){
    $pessoa_retorno = (object) [];
    $pessoa_retorno->id = $pessoa->id;
    $pessoa_retorno->nome = $pessoa->nome;
    $pessoa_retorno->rg = $pessoa->rg;
    $pessoa_retorno->cpf = $pessoa->cpf;
    $pessoa_retorno->telefone = $pessoa->contatos->telefone;
    $pessoa_retorno->celular = $pessoa->contatos->celular;
    $pessoa_retorno->cep = $pessoa->endereco->cep;
    $pessoa_retorno->logradouro = $pessoa->endereco->logradouro;
    $pessoa_retorno->numero = $pessoa->endereco->numero;
    $pessoa_retorno->bairro = $pessoa->endereco->bairro;
    $pessoa_retorno->cidade = $pessoa->endereco->cidade;
    $pessoa_retorno->condominio_id = $pessoa->endereco->condominio_id;
    return $pessoa_retorno;
  }


  public function update(SindicoRequest $request, $id){

    $sindico = $this->PessoaModel->sindicos()->find($id);
    if (!$sindico) {
      return redirect('sindicos');
    }

    //atualiza dados pessoais
    $sindico->update($request->only('nome', 'rg','cpf'));
    //atualiza contatos pessoais
    $sindico->contatos()->update($request->only('telefone', 'celular'));
    //atualiza endereco pessoais
    $sindico->endereco()->update($request->only('logradouro', 'numero','bairro','cidade','cep','condominio_id'));


    \Session::flash('success_message','sindico atualizado!');
    return redirect()->back();
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $sindico =  $this->PessoaModel->find($id);
    if (!$sindico) {
      return redirect('sindicos');
    }

    $sindico->usuario->forceDelete();
    \Session::flash('success_message','sindico excluido!');
    return redirect()->back();
  }



  public function changeStatus($id){
    // usuario com pessoa de id = $id
    $sindico =    $this->PessoaModel->find($id);
    if (!$sindico) {
      return redirect('sindicos');
    }
    if($sindico->usuario->desativado_em){
      $sindico->usuario->restore();
    }else {
      $sindico->usuario->delete();
    }
    return redirect()->back();
  }


}
