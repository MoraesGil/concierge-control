<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
  // id, logradouro, numero, cep, condominio_id
  protected $fillable =
  ['logradouro', 'numero', 'cep', 'condominio_id'];

  public $timestamps = false;

  public function morador()
  {
    return $this->hasOne('App\Pessoa');
  }

  public function condominio()
  {
    return $this->belongsTo('App\Condominio');
  }
}
