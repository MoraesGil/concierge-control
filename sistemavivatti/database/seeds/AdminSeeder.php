<?php

use Illuminate\Database\Seeder;
use App\Usuario;

class AdminSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $senha =  \Hash::make('gilberto'); //criptografia

    //cria usuario
    $novo_usuario = App\Usuario::create([
      'permissao'=>'a', 'login'=>'admin', 'senha'=>$senha
    ]);

    //grava dados pessoais
    $novo_usuario->dados_pessoais()->create(['nome'=>'Gilberto Prudêncio Vaz de Moraes']);
  }
}
