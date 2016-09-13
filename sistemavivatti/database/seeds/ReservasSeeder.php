<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use Faker\Factory as Faker;

class ReservasSeeder extends Seeder
{
  public function run()
  {
    $faker = Faker::create();

    $dt_entrada =  date('y:m:d');
    $dt_saida =Date('y:m:d', strtotime("+2 days"));

    $reserva = Usuario::find(2)->reservas()->create(
    [
      'data_entrada'=> $dt_entrada ,
      'data_saida'=>$dt_saida
    ]);

    $reserva->convidados()->create(['nome'=>$faker->name]);
  }
}
