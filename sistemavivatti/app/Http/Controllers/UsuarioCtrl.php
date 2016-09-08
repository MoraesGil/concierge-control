<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Requests;

use App\Usuario;

class UsuarioCtrl extends Controller
{
  public function index(){
    return redirect('/moradores');
  }

  public function login(){
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
    if(\Hash::check('admin', $usuario!==null ? $usuario->senha : ''))
    {
      if (Auth::loginUsingId($usuario->id,$request->has('remember'))) {
        return redirect('/home');
      }else {
        return 'bloqueado';
      }
    }
    else
    {
      return Auth::check() ? 'on' : 'off';
    }
  }

  public function sair(){
    Auth::logout();
    return redirect('/login');
  }

}
