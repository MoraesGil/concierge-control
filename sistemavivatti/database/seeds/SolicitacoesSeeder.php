<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use Faker\Factory as Faker;

class SolicitacoesSeeder extends Seeder
{
  // REF BD
  // anonimo = 0,1,
  // tipo 0-3, 0 == outros 1 == recado 2 == reclamação 3 == problemas
  // prioridade, 0 == normal 1 == media 2 == alta
  // detalhes, text

  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $faker = Faker::create();

    foreach (Usuario::limit(10)->get() as $usuario) {
      $usuario->solicitacoes()->create(
      [
        'anonimo'=>$faker->boolean(30) , //$chanceOfGettingTrue = 30%
        'tipo'=>$faker->numberBetween(0,3),
        'prioridade'=>$faker->numberBetween(0,2),
        'detalhes'=>$faker->text,
      ]);
    }   
  }
}
