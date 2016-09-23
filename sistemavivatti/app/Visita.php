<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
  // id, porteiro_id, morador_id, visitante_id, entrada, veiculo_id, criado_em
  protected $fillable = ['porteiro_id', 'visitante_id','veiculo_id'];

  protected $hidden =[''];

  public $timestamps = false;

 
  public function morador()
  {
    return $this->belongsTo('App\Pessoa','morador_id');
  }

  //---------------------------------
  public function visitante()
  {
    return $this->belongsTo('App\Pessoa','visitante_id');
  }

  //---------------------------------

  public function porteiro()
  {
    return $this->belongsTo('App\Pessoa','porteiro_id');
  }


  //---------------------------------
  public function veiculo()
  {
    return $this->belongsTo('App\Veiculo','veiculo_id');
  }

}
