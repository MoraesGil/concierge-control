<?php

use Illuminate\Database\Seeder;
use App\Servico;
use Faker\Factory as Faker;

class ServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();

      Servico::create(['nome'=>'Encanamentos']);
      Servico::create(['nome'=>'Reforma']);
      Servico::create(['nome'=>'Eletrica']);
      Servico::create(['nome'=>'Hidraulica']);

      foreach (range(1,10) as $i) {
        Servico::create(['nome'=>$faker->jobTitle]);
      }
    }
}
