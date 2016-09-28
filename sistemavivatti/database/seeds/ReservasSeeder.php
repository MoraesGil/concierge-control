<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use App\Pessoa;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Evento;

class ReservasSeeder extends Seeder
{
  public function run()
  {
    $faker = Faker::create();
    $pessoaModel  = new Pessoa;
    $eventoModel = new Evento;

    $usuarios_ids =  Usuario::limit(20)->pluck('id')->toArray();
    shuffle($usuarios_ids);

    $visitantes_id = $pessoaModel->visitantes()
    ->orderBy('nome', 'ASC')
    ->limit(20)->pluck('id')->toArray();
    shuffle($visitantes_id);

    foreach (range(1,10) as $index) {

      do {
        if ($index == 1) {
          $dt_entrada =  $faker->dateTimeThisMonth();
        }
        else {
          $dt_entrada =  $faker->dateTimeThisYear();
        }

        $dt_saida = new DateTime($dt_entrada->format('Y-m-d H:i:s'));

        switch ($faker->numberBetween($min = 0, $max = 3)) {
          case 1:
          $dt_saida->modify('+1 day');
          break;
          case 2:
          $dt_saida->modify('+2 day');
          break;
          case 3:
          $dt_saida->modify('+3 day');
          break;
          default:

          break;
        }
        // echo $dt_entrada->format('Y/m/d').' - ';
        // echo $dt_saida->format('Y/m/d').' /// ';
        $dt_entrada = $dt_entrada->format('d/m/Y');
        $dt_saida =  $dt_saida->format('d/m/Y');

      } while (!$eventoModel->data_disponivel($dt_entrada,$dt_saida));
 
      $reserva = Usuario::find($usuarios_ids[$index])->reservas()->create(
      [
        'data_entrada'=> $dt_entrada ,
        'data_saida'=>$dt_saida
      ]);

      foreach (range(1, $faker->numberBetween($min = 1, $max = 11)) as $index2) {
        if ($faker->boolean(80)) {
          $reserva->convidados()->create(['nome'=>$faker->name]);
        }else {
          $reserva->convidados()->create([
            'nome'=>$pessoaModel->find($visitantes_id[$index2])->nome,
            'pessoa_id'=>$visitantes_id[$index2]
          ]);
        }
      }

    }
  }
}
