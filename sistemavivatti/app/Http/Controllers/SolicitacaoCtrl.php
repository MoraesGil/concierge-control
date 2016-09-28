<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SolicitacaoRequest;
use App\Solicitacao;

class SolicitacaoCtrl extends Controller
{
  public function __construct(Solicitacao $s){
    $this->SolicitacaoModel = $s;
    $this->pagLimit = 5;
  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno =   $this->SolicitacaoModel
      ->where("titulo", "LIKE", "%$filtro%")
      ->orWhere("descricao", "LIKE", "%$filtro%")
      ->orderBy('id', 'DESC')
      ->withTrashed();

      if (!(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' )) {
        $retorno = $retorno->where('usuario_id',  auth()->user()->id);
      }

      $retorno = $retorno->paginate($this->pagLimit);

    }else {
      $retorno =   $this->SolicitacaoModel->orderBy('id', 'DESC')->withTrashed();


      if (!(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' )) {
        $retorno = $retorno->where('usuario_id',  auth()->user()->id);
      }

      $retorno = $retorno->paginate($this->pagLimit);
    }

    return view('solicitacoes.list',['solicitacoes'=>$retorno]);
  }


  public function store(SolicitacaoRequest $request){

    auth()->user()->solicitacoes()->create($request->all());

    \Session::flash('success_message','Solicitacao cadastrada!');

    return redirect()->back();
  }


  public function destroy($id){
    // usuario com pessoa de id = $id
    $solicitacao =  $this->SolicitacaoModel->withTrashed()->find($id);

    if (!$solicitacao) {
      return redirect('solicitacoes');
    }

    if (auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' || auth()->user()->id == $solicitacao->usuario->id) {
      $solicitacao->forceDelete();
      \Session::flash('success_message','Solicitacao excluida!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Você não tem permissão para excluir']);
    }
  }

  public function finalizar($id){
    // usuario com pessoa de id = $id
    $solicitacao =  $this->SolicitacaoModel->withTrashed()->find($id);

    if (!$solicitacao) {
      return redirect('solicitacoes');
    }

    if (auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' || auth()->user()->id == $solicitacao->usuario->id) {
      $solicitacao->delete();
      \Session::flash('success_message','Solicitacao excluida!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Você não tem permissão para excluir']);
    }
  }

}
