<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CondominoRequest;
use App\Pessoa;
use App\Usuario;
use App\Condominio;

class CondominoCtrl extends Controller
{
  public function __construct(Pessoa $p, Condominio $c, Usuario $u){
    $this->PessoaModel = $p;
    $this->CondominioModel = $c;
    $this->UsuarioModel = $u;
    $this->pagLimit = 7;
  }

  public function index(Request $request){
    $filtro = trim($request->get('busca'))  ;

    if ($filtro) {
      $retorno = $this->PessoaModel->moradores()
      ->orderBy('nome', 'ASC')
      ->where("nome", "LIKE", "%$filtro%")
      ->orWhere("cpf", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno = $this->PessoaModel->moradores()->orderBy('nome', 'ASC')->paginate($this->pagLimit);
    }

    return view('condominos.list',['moradores'=>$retorno]);
  }

  public function create(){
    // $backUrl = redirect()->back()->getTargetUrl();
    return view('condominos.form',['condominios'=>$this->CondominioModel->lists('nome','id')]);
  }

  public function store(CondominoRequest $request){

    $cpf3 = substr($request->get('cpf'), 0, 3);//3 primeiros digitos cpf

    $login = substr(str_replace(' ', '', $request->get('nome')), 0, 5);//nome 5 primeiras letras

    $login .= $cpf3;
    $senha = 'nova'.$cpf3;
    $senha =  \Hash::make($senha); //criptografia

    //cria usuario
    $novo_usuario = $this->UsuarioModel->create([
      'permissao'=>'m', 'login'=>strtolower($login), 'senha'=>$senha
    ]);

    //grava dados pessoais
    $novo_usuario->dados_pessoais()->create($request->only('nome', 'rg','cpf'));
    //grava contatos pessoais
    $novo_usuario->dados_pessoais->contatos()->create($request->only('telefone', 'celular','email'));

    //grava endereco pessoais
    $novo_usuario->dados_pessoais->endereco()->create($request->only('logradouro', 'numero','bairro','cidade','cep','condominio_id'));

    \Session::flash('success_message','Morador cadastrado!');

    return redirect()->back();
  }

  public function edit($id){

    $morador = $this->PessoaModel->moradores()->find($id);

    if (!$morador) {
      return redirect('moradores');
    }

    $data = array(
      'morador'=>$this->transform_pessoa($morador),
      'condominios'=>$this->CondominioModel->lists('nome','id')
    );
    return view('condominos.form',$data);
  }

  public function update(CondominoRequest $request, $id){

    $morador = $this->PessoaModel->moradores()->find($id);
    if (!$morador) {
      return redirect('moradores');
    }

    //atualiza dados pessoais
    $morador->update($request->only('nome', 'rg','cpf'));
    //atualiza contatos pessoais
    $morador->contatos()->update($request->only('telefone', 'celular','email'));
    //atualiza endereco pessoais
    $morador->endereco()->update($request->only('logradouro', 'numero','bairro','cidade','cep','condominio_id'));


    \Session::flash('success_message','Morador atualizado!');
    return redirect()->back();
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $morador =  $this->PessoaModel->find($id);
    if (!$morador) {
      return redirect('moradores');
    }

    $morador->usuario->forceDelete();
    \Session::flash('success_message','Morador excluido!');
    return redirect()->back();
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
    $pessoa_retorno->condominio_id = $pessoa->endereco->condominio_id;
    return $pessoa_retorno;
  }

  public function changeStatus($id){
    // usuario com pessoa de id = $id
    $morador =    $this->PessoaModel->find($id);
    if (!$morador) {
      return redirect('moradores');
    }
    if($morador->usuario->desativado_em){
      $morador->usuario->restore();
    }else {
      $morador->usuario->delete();
    }
    return redirect()->back();
  }

 


}
