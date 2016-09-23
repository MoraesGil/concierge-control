<?php

use Illuminate\Database\Seeder;
use App\Veiculo;
use App\Pessoa;
use Faker\Factory as Faker;
class VisitasSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $pesModel = new Pessoa;
    $veiculoModel =  new Veiculo;
    $faker = Faker::create();
    $moradores = $pesModel->moradores()->limit(10)->get();
    $prestadoresIds = $pesModel->prestadores()->pluck('id')->toArray();
    $porteirosIds = $pesModel->porteiros()->pluck('id')->toArray();

    foreach ($moradores as $morador) {
      shuffle($prestadoresIds);
      shuffle($porteirosIds);

      foreach (range(1,3) as  $index) {
        $visita_id = $prestadoresIds[$index];
        //registra placa e vincula a visitante.
        $a = $faker->randomLetter;
        $b = $faker->randomLetter;
        $c = $faker->randomLetter;
        $veiculo  = $veiculoModel->create(['placa'=>$a.$b.$c.'-'.$faker->numerify($string = '####')]);
        $veiculo->utilizadores()->attach($visita_id);

        $morador->visitas()->create([
          'porteiro_id'=>$porteirosIds[$index],
          'visitante_id'=>$visita_id,
          'veiculo_id'=>$faker->boolean(70) ? $veiculo->id : null]);
        }
      }
    }
  }
