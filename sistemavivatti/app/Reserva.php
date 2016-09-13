<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
  protected $fillable = ['data_entrada', 'data_saida', 'usuario_id'];

  public $timestamps = false;


  public function convidados()
  {
    return $this->hasMany('App\Convidado');
  }

  public function usuario()
  {
    return $this->belongsTo('App\Usuario');
  }

  public function ManyToMany()
  {
    return $this->belongsToMany('App\Exemplo');
  }

  const CREATED_AT = 'criado_em';
  const UPDATED_AT = 'atualizado_em';
}
