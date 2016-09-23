<?php

use Illuminate\Database\Seeder;
use App\Veiculo;
use Faker\Factory as Faker;
class VeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      foreach (range(1,2) as $i) {
        $a = $faker->randomLetter;
        $b = $faker->randomLetter;
        $c = $faker->randomLetter;
        $prestador->veiculos()->create(['placa'=>$a.$b.$c.'-'.$faker->numerify($string = '####')]);
      }
    }
}
