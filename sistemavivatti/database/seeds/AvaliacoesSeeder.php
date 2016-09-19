<?php

use Illuminate\Database\Seeder;
use App\Pessoa;
use Faker\Factory as Faker;
class AvaliacoesSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $faker = Faker::create();
    $pesModel = new Pessoa;
    $prestadores = $pesModel->prestadores()->get();
    $moradores = $pesModel->moradores()->get();

    foreach ($prestadores as $prestador) {
      foreach ($moradores as $morador) {
        if ($faker->boolean(80)) {
          $prestador->avaliacoes()->attach($morador->usuario->id,['nota'=>$faker->numberBetween(1,5)]);
        }
      }
    } 
  }
}
