<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EventoRequest;
use App\Evento;

class EventoCtrl extends Controller
{
  public function __construct(Evento $s){
    $this->EventoModel = $s;
    $this->pagLimit = 5;
  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno =   $this->EventoModel
      ->where("titulo", "LIKE", "%$filtro%")
      ->orWhere("descricao", "LIKE", "%$filtro%")
      ->orderBy('id', 'DESC');

      if (!(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' )) {
        $retorno = $retorno->where('usuario_id', auth()->user()->id);
      }

      $retorno = $retorno->paginate($this->pagLimit);

    }else {
      $retorno =   $this->EventoModel->orderBy('id', 'DESC');


      if (!(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' )) {
        $retorno = $retorno->where('usuario_id',  auth()->user()->id);
      }

      $retorno = $retorno->paginate($this->pagLimit);
    }

    return view('eventos.list',['eventos'=>$retorno]);
  }

  public function create(){
    $calendar = \Calendar::addEvents(Evento::all())->setOptions([ //set fullcalendar options
      'header'=> [
        'right'=> 'prev,next today',
      ],
    ]);
    return view('eventos.form',['calendar'=>$calendar]);
  }

  public function store(EventoRequest $request){

    if (!$this->EventoModel->data_disponivel($request->get("data_entrada"),$request->get("data_saida"),null)) {
      return redirect()->back()->withInput()->withErrors(['erro'=>'Periodo indísponivel.']);
    }

    auth()->user()->reservas()->create($request->only('data_entrada','data_saida'));

    \Session::flash('success_message','Evento cadastrado!');

    return redirect()->back();
  }

  public function edit($id){
    if (!(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's')) {
      return redirect('eventos')->withErrors(['Você não tem permissão para editar eventos']);
    }
    $evento = $this->EventoModel->find($id);

    if (!$evento) {
      return redirect('eventos');
    }

    $calendar = \Calendar::addEvents(Evento::all())->setOptions([ //set fullcalendar options
      'header'=> [
        'right'=> 'prev,next today',
      ],
    ]);

    return view('eventos.form',['evento'=>$evento,'calendar'=>$calendar]);
  }

  public function update(EventoRequest $request, $id){

    if (!(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's')) {
      return redirect('eventos')->withErrors(['Você não tem permissão para editar eventos']);
    }


    $evento = $this->EventoModel->find($id);
    if (!$evento) {
      return redirect('eventos');
    }

    if (!$this->EventoModel->data_disponivel($request->get("data_entrada"),$request->get("data_saida"),$id)) {
      return redirect()->back()->withInput()->withErrors(['erro'=>'Periodo indísponivel.']);
    }

    $evento->update($request->only('data_entrada','data_saida'));

    \Session::flash('success_message','Evento atualizado!');

    return redirect()->back();
  }

  public function destroy($id){
    $evento =  $this->EventoModel->find($id);

    if (!$evento) {
      return redirect('eventos');
    }

    if (auth()->user()->permissao == 'a' || auth()->user()->permissao == 's') {
      $evento->delete();
      \Session::flash('success_message','Evento excluido!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Você não tem permissão para excluir']);
    }
  }


}
