<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
  // id, pessoa_id, placa
  protected $fillable = ['placa'];

  public $timestamps = false;

  protected $hidden = ['pivot'];

  public function utilizadores()
  {
    return $this->belongsToMany('App\Pessoa','usuarios_veiculo','veiculo_id','pessoa_id');
  }

  ////mutators
  public function getPlacaAttribute()
  {
    return strtoupper($this->attributes['placa']);
  }

}
