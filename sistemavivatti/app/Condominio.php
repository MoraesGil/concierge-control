<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
  protected $fillable =
  ['nome'];

  public $timestamps = false;


  public function enderecos()
  {
    return $this->hasMany('App\Endereco');
  }

  public function moradores()
  {
    return $this->hasManyThrough('App\Pessoa', 'App\Endereco');
  }
}
