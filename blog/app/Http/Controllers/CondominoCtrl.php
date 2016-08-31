<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pessoa;
use App\Condominio;

class CondominoCtrl extends Controller
{
  public function __construct(Pessoa $p, Condominio $c){
    $this->PessoaModel = $p;
    $this->CondominioModel = $c;
 
  }

  public function index(){


    return view('condominos.list',['moradores'=>$this->PessoaModel->moradores()]);
  }

  public function create(){
    return view('condominos.form',['condominios'=>$this->CondominioModel->all()]);
  }

  public function store(Request $request){
    return 'post disparado';
  }

  public function edit(){

  }

  public function update(){
    return 'put disparado';
  }

  public function destroy(){
    return 'delete disparado';
  }

}
