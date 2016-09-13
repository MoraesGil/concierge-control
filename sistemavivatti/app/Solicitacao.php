<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
  protected $table ='solicitacoes';


  protected $fillable = ['usuario_id', 'anonimo', 'tipo', 'prioridade', 'detalhes', 'finalizado_em'];

  protected $hidden =[''];

  public $timestamps = false;


  public function usuario()
  {
    return $this->belongsTo('App\Usuario');
  }

  const CREATED_AT = 'criado_em'; 

}
