<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\RecadoRequest;
use App\Recado;

class RecadoCtrl extends Controller
{
  public function __construct(Recado $s){
    $this->RecadoModel = $s;
    $this->pagLimit = 5;
  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno =   $this->RecadoModel
      ->where("titulo", "LIKE", "%$filtro%")
      ->orWhere("descricao", "LIKE", "%$filtro%")
      ->orderBy('id', 'DESC')
      ->paginate($this->pagLimit);
    }else {
      $retorno =   $this->RecadoModel->orderBy('id', 'DESC')->paginate($this->pagLimit);
    }

    return view('recados.list',['recados'=>$retorno]);
  }


  public function store(RecadoRequest $request){

    auth()->user()->recados()->create($request->only('titulo','descricao'));

    \Session::flash('success_message','Recado cadastrado!');

    return redirect()->back();
  } 

  public function destroy($id){
    // usuario com pessoa de id = $id
    $recado =  $this->RecadoModel->find($id);
    if (!$recado) {
      return redirect('recados');
    }

    if (auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' || auth()->user()->id == $recado->usuario->id) {
      $recado->delete();
      \Session::flash('success_message','Recado excluido!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Você não tem permissão para excluir']);
    }
  }

}
