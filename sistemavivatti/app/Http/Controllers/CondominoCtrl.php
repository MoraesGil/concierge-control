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

  }

  public function index(){

  $moradores = $this->PessoaModel->moradores()->paginate(3);

    return view('condominos.list',['moradores'=>$moradores]);
  }

  public function create(){
    return view('condominos.form',['condominios'=>$this->CondominioModel->lists('nome','id')]);
  }

  public function store(CondominoRequest $request){

    // dd($request->all());

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


    return redirect('morador/novo');
  }

  public function edit($id){

    $morador = $this->PessoaModel->moradores()->find($id);

    if (!$morador) {
      return redirect('moradores');
    }

    $data = array(
      'morador'=>$this->transform_morador($morador),
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
    return redirect('morador/'.$id.'/editar');
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $morador =  $this->PessoaModel->find($id);
    if (!$morador) {
      return redirect('moradores');
    }

    $morador->usuario->forceDelete();
    \Session::flash('success_message','Morador excluido!');
    return redirect('moradores');
  }

  private function transform_morador($m){
    $morador = (object) [];
    $morador->id = $m->id;
    $morador->nome = $m->nome;
    $morador->rg = $m->rg;
    $morador->cpf = $m->cpf;
    $morador->telefone = $m->contatos->telefone;
    $morador->celular = $m->contatos->celular;
    $morador->email = $m->contatos->email;
    $morador->cep = $m->endereco->cep;
    $morador->logradouro = $m->endereco->logradouro;
    $morador->numero = $m->endereco->numero;
    $morador->bairro = $m->endereco->bairro;
    $morador->cidade = $m->endereco->cidade;
    $morador->condominio_id = $m->endereco->condominio_id;
    return $morador;
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
    return redirect('moradores');
  }


}
