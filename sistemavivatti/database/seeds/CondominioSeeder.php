<?php

use Illuminate\Database\Seeder;
use App\Condominio;
use Faker\Factory as Faker;

class CondominioSeeder extends Seeder
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
      Condominio::create(['nome'=>'Condomonio '.$faker->name]);
    }
  }
}
