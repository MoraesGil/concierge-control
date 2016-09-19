<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use Faker\Factory as Faker;
class MoradorSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $faker = Faker::create();

    foreach (range(1,10) as $i) {
      //variaveis
      $nome = $faker->name;
      $rg =  $faker->numerify($string = '#########');
      $cpf =  $faker->numerify($string = '############');
      $telefone =  $faker->numerify($string = '##########');
      $celular =  $faker->numerify($string = '###########');
      $email = $faker->email;

      $logradouro = $faker->streetName;
      $numero = $faker->numberBetween(1,200);
      $bairro = $faker->streetName;
      $cidade = $faker->city;
      $cep = $faker->postcode;
      $condominio_id = $faker->numberBetween(1,10);

      //variaveis end
      $cpf3 = substr($cpf, 0, 3);//3 primeiros digitos cpf

      $login = substr(str_replace(' ', '', $nome), 0, 5);//nome 5 primeiras letras

      $login .= $cpf3;
      $senha = 'nova'.$cpf3;
      $senha =  \Hash::make('teste'); //criptografia

      //cria usuario
      $novo_usuario = App\Usuario::create([
        'permissao'=>'m', 'login'=>strtolower($login), 'senha'=>$senha
      ]);

      //grava dados pessoais
      $novo_usuario->dados_pessoais()->create(['nome'=>$nome, 'rg'=>$rg,'cpf'=>$cpf]);
      //grava contatos pessoais
      $novo_usuario->dados_pessoais->contatos()->create(['telefone'=>$telefone, 'celular'=>$celular,'email'=>$email]);

      // grava endereco pessoais
      $novo_usuario->dados_pessoais->endereco()->
      create(['logradouro'=>$logradouro,
      'numero'=>$numero,
      'bairro'=>$bairro,
      'cidade'=>$cidade,
      'cep'=>$cep ,
      'condominio_id'=> $condominio_id]);

      if ($faker->boolean(80)) {
        foreach (range(1,5) as $index) {
          $novo_usuario->dados_pessoais->dependentes()->create(['nome'=>$faker->name, 'rg'=>$faker->numerify($string = '#########'),'data_nascimento'=>$faker->dateTimeThisCentury->format('d/m/Y')]);
        }
      }

      if ($faker->boolean(80)) {
        foreach (range(1,2) as $i) {
          $a = $faker->randomLetter;
          $b = $faker->randomLetter;
          $c = $faker->randomLetter;
          $novo_usuario->dados_pessoais->veiculos()->create(['placa'=>$a.$b.$c.'-'.$faker->randomNumber($nbDigits = 4)]);
        }
      }


    }
  }
}
