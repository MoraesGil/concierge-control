<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use Faker\Factory as Faker;
class RecadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       $faker = Faker::create();

       foreach (Usuario::limit(10)->get() as $usuario) {
         $usuario->recados()->create(
         [
           'titulo'=>$faker->text($maxNbChars = 45),
           'descricao'=>$faker->text,
         ]);
       }
     }
}
