<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
  //id, usuario_id, nome, rg, cpf, avatar_url, datanasc, dependete_id

  public function contato(){
    return $this->hasOne('App\Contato','usuario_id');
  }

  // App\Pessoa::find(1)->contato
  //
  // ->create(['email'=>'testemail','telefone'=>'456789876','celular'=>'celular111','usuario_id'=>1]);

}
