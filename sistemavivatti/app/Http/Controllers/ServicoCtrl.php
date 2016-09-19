<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ServicoRequest;
use App\Servico;

class ServicoCtrl extends Controller
{
  public function __construct(Servico $s){
    $this->ServicoModel = $s;
    $this->pagLimit = 7;
  }

  public function index(Request $request){
    $filtro = $request->get('busca');

    if ($filtro) {
      $retorno =   $this->ServicoModel
      ->where("nome", "LIKE", "%$filtro%")
      ->paginate($this->pagLimit);
    }else {
      $retorno =   $this->ServicoModel->paginate($this->pagLimit);
    }

    return view('servicos.list',['servicos'=>$retorno]);
  }
 
  public function create(){
    return view('servicos.form');
  }

  public function store(ServicoRequest $request){

    $this->ServicoModel->create($request->all());

    \Session::flash('success_message','servico cadastrado!');

    return redirect()->back();
  }

  public function edit($id){

    $servico = $this->ServicoModel->find($id);

    if (!$servico) {
      return redirect('servicos');
    }
    return view('servicos.form',['servico'=>$servico]);
  }

  public function update(ServicoRequest $request, $id){

    $servico = $this->ServicoModel->find($id);
    if (!$servico) {
      return redirect('servicos');
    }

    $servico->update($request->only('nome'));

    \Session::flash('success_message','Serviço atualizado!');
    return redirect()->back();
  }

  public function destroy($id){
    // usuario com pessoa de id = $id
    $servico =  $this->ServicoModel->find($id);
    if (!$servico) {
      return redirect('servicos');
    }
    if ($servico->fornecedores_total== 0) {
      $servico->delete();
      \Session::flash('success_message','Serviço excluido!');
      return redirect()->back();
    }else{
      return redirect()->back()->withErrors(['Há Fornecedores vinculados ao seriço de cod: '.$servico->id.', este serviço não pode ser excluido']);
    }
  }

}
