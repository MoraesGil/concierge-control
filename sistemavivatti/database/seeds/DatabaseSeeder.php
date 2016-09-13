<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $this->call(AdminSeeder::class);
    $this->call(CondominioSeeder::class);
    $this->call(VeiculosSeeder::class);
    $this->call(ServicosSeeder::class);

    $this->call(MoradorSeeder::class);
    $this->call(PorteirosSeeder::class);
    $this->call(SindicosSeeder::class);

    $this->call(SolicitacoesSeeder::class);
    $this->call(ReservasSeeder::class);
  }
}
