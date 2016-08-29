<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
  protected $fillable =
  ['nome'];

  protected $hidden =['pivot'];

  public $timestamps = false;

  public function fornecedores()
  {
    return $this->belongsToMany('App\Pessoa', 'servicos_prestador', 'servico_id','pessoa_id');
  }


}
