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
    $this->call(ServicosSeeder::class);

    //usuarios faker
    $this->call(MoradorSeeder::class);
    $this->call(PorteirosSeeder::class);
    $this->call(SindicosSeeder::class);

    $this->call(PrestadorSeeder::class);

    $this->call(SolicitacoesSeeder::class);
    $this->call(RecadosSeeder::class);

    $this->call(AvaliacoesSeeder::class);

    $this->call(VisitasSeeder::class);
    $this->call(ReservasSeeder::class);

  }
}
