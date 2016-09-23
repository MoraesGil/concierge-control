<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\eventoRequest;
use App\evento;

class EventoCtrl extends Controller
{
  public function __construct(Evento $s){
    $this->EventoModel = $s;
    $this->pagLimit = 5;
  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    // if ($filtro) {
    //   $retorno =   $this->EventoModel
    //   ->where("titulo", "LIKE", "%$filtro%")
    //   ->orWhere("descricao", "LIKE", "%$filtro%")
    //   ->orderBy('id', 'DESC')
    //   ->paginate($this->pagLimit);
    // }else {
    //   $retorno =   $this->EventoModel->orderBy('id', 'DESC')->paginate($this->pagLimit);
    // }

    return view('eventos.list');
  }


  public function store(eventoRequest $request){

    auth()->user()->eventos()->create($request->only('titulo','descricao'));

    \Session::flash('success_message','evento cadastrado!');

    return redirect()->back();
  }



  public function update(eventoRequest $request, $id){

    $evento = $this->EventoModel->find($id);
    if (!$evento) {
      return redirect('eventos');
    }

    $evento->update($request->only('nome'));

    \Session::flash('success_message','Serviço atualizado!');
    return redirect()->back();
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $evento =  $this->EventoModel->find($id);
    if (!$evento) {
      return redirect('eventos');
    }

    if (auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' || auth()->user()->id == $evento->usuario->id) {
      $evento->delete();
      \Session::flash('success_message','evento excluido!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Você não tem permissão para excluir']);
    }
  }
}
