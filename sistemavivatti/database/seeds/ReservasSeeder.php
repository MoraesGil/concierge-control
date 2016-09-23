<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use App\Pessoa;
use Faker\Factory as Faker;

class ReservasSeeder extends Seeder
{
  public function run()
  {
    $faker = Faker::create();
    $pessoaModel  = new Pessoa;
    $dt_entrada =  date('y:m:d');
    $dt_saida = Date('y:m:d', strtotime("+2 days"));

    $visitantes_id = $pessoaModel->visitantes()
    ->orderBy('nome', 'ASC')
    ->limit(10)->pluck('id');
 

    $reserva = Usuario::find(2)->reservas()->create(
    [
      'data_entrada'=> $dt_entrada ,
      'data_saida'=>$dt_saida
    ]);


    foreach (range(1,10) as $key) {

      if ($faker->boolean(80)) {
        $reserva->convidados()->create(['nome'=>$faker->name]);
      }else {
        $reserva->convidados()->create(['pessoa_id'=>$visitantes_id[$key]]);
      }


    }


  }
}
