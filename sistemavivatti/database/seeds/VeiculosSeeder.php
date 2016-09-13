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

      foreach (range(1,20) as $i) {

        $a = $faker->randomLetter;
        $b = $faker->randomLetter;
        $c = $faker->randomLetter;
        Veiculo::create(['placa'=>$faker->randomNumber($nbDigits = 3).$a.$b.$c]);
      }
    }
}
