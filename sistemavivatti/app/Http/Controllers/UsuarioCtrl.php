<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Requests;

use App\Usuario;
use App\Recado;
use App\Pessoa;
use App\Servico;

use App\Evento;

class UsuarioCtrl extends Controller
{
  public function home(Recado $recado, Pessoa $pes, Servico $ser, Evento $eventos){

    $calendar = \Calendar::addEvents($eventos->all())->setOptions([ //set fullcalendar options
      'header'=> [
        'right'=> 'prev,next today',
      ] 
    ]);

    $data = array(
      'recados'=>$recado->orderBy('id', 'DESC')->limit(5)->get(),
      'total_pessoas' => count($pes->all()),
      'total_moradores' => count($pes->moradores()->get()),
      'total_prestadores' => count($pes->prestadores()->get()),
      'total_servicos' => count($ser->all()),
      'calendar'=>$calendar
    );

    return view('home',$data);
  }
  public function index(){
    return redirect('/moradores');
  }

  public function login(){
    if (Auth::check()) {
      return redirect('/home');
    }
    return view('login');
  }

  public function postLogin(Request $request){
    $validator = Validator::make($request->all(), [
      'login' => 'required',
      'senha' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect('/login')
      ->withErrors($validator)
      ->withInput();
    }

    $usuario = Usuario::where('login','=',$request->get('login'))->withTrashed()->first();

    //recupero usuario e se ele nao for nulo comparo a senha.
    if(\Hash::check($request->get('senha'), $usuario!==null ? $usuario->senha : ''))
    {
      if (Auth::loginUsingId($usuario->id,$request->has('remember'))) {
        return redirect('/home');
      }else {
        return 'bloqueado';
      }
    }
    else
    {
      // dd($request->all());
      // return Auth::check() ? 'on' : 'off';
      return redirect('/login')
      ->withErrors(['teste']);
    }
  }

  public function sair(){
    Auth::logout();
    return redirect('/login');
  }

}
