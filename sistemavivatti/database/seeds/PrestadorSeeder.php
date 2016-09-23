<?php

use Illuminate\Database\Seeder;
use App\Pessoa;
use Faker\Factory as Faker;

class PrestadorSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $faker = Faker::create();

    $idsMoradores = App\Pessoa::whereIn('usuario_id', \DB::table('usuarios')->where('permissao','m')->distinct()->pluck('id'))->limit(10)->pluck('id');

    foreach (range(1,10) as $i) {

      if ($faker->boolean(70)) {//salva prestador de serviço comum
        //variaveis
        $nome = $faker->name;
        $rg =  $faker->numerify($string = '#########');
        $cpf =  $faker->numerify($string = '############');
        $telefone =  $faker->numerify($string = '##########');
        $celular =  $faker->numerify($string = '###########');

        $logradouro = $faker->streetName;
        $numero = $faker->numberBetween(1,200);
        $bairro = $faker->streetName;
        $cidade = $faker->city;
        $cep = $faker->postcode;

        //grava dados pessoais
        $prestador  = Pessoa::create(['nome'=>$nome, 'rg'=>$rg,'cpf'=>$cpf]);
        //grava contatos pessoais
        $prestador->contatos()->create(['telefone'=>$telefone, 'celular'=>$celular]);

        // grava endereco pessoais
        $prestador->endereco()->
        create(['logradouro'=>$logradouro,
        'numero'=>$numero,
        'bairro'=>$bairro,
        'cidade'=>$cidade,
        'cep'=>$cep ]);

        if ($faker->boolean(80)) {
          $prestador->servicos_prestados()->sync([$faker->numberBetween(1,10)]);
        }else {
          $prestador->servicos_prestados()->sync([1,2,3]);
        }
      }

      //gera empresa CNPJ com dependentes
      else {
        //variaveis
        $nome = $faker->name;
        $cnpj =  $faker->numerify($string = '##############');

        $telefone =  $faker->numerify($string = '##########');
        $celular =  $faker->numerify($string = '#########');

        $logradouro = $faker->streetName;
        $numero = $faker->numberBetween(1,200);
        $bairro = $faker->streetName;
        $cidade = $faker->city;
        $cep = $faker->postcode;

        //grava dados pessoais
        $prestador  = Pessoa::create(['nome'=>$nome,'cnpj'=>$cnpj]);
        //grava contatos pessoais
        $prestador->contatos()->create(['telefone'=>$telefone, 'celular'=>$celular]);

        // grava endereco pessoais
        $prestador->endereco()->
        create(['logradouro'=>$logradouro,
        'numero'=>$numero,
        'bairro'=>$bairro,
        'cidade'=>$cidade,
        'cep'=>$cep ]);


        if ($faker->boolean(80)) {
          $prestador->servicos_prestados()->sync([$faker->numberBetween(1,10)]);
        }else {
          $prestador->servicos_prestados()->sync([1,2,3]);
        }


        // GERA FUNCIONARIOS
        foreach (range(1,5) as $index) {
          $nome = $faker->name;
          $rg =  $faker->numerify($string = '#########');
          $cpf =  $faker->numerify($string = '############');
          $telefone =  $faker->numerify($string = '#########');
          $celular =  $faker->numerify($string = '#########');

          $logradouro = $faker->streetName;
          $numero = $faker->numberBetween(1,200);
          $bairro = $faker->streetName;
          $cidade = $faker->city;
          $cep = $faker->postcode;

          //grava dados pessoais
          $funcionario = $prestador->dependentes()->create(['nome'=>$nome, 'rg'=>$rg,'cpf'=>$cpf]);
          //grava contatos pessoais
          $funcionario->contatos()->create(['telefone'=>$telefone, 'celular'=>$celular]);

          // grava endereco pessoais
          $funcionario->endereco()->
          create(['logradouro'=>$logradouro,
          'numero'=>$numero,
          'bairro'=>$bairro,
          'cidade'=>$cidade,
          'cep'=>$cep ]);
        }

      }//fim else CNPJ
    }
  }

}
