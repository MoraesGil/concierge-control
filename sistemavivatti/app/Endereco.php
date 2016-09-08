<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
  // id, pessoa_id, logradouro, numero, bairro, complemento, cep, condominio_id
  protected $fillable =
  ['pessoa_id', 'logradouro', 'numero', 'bairro', 'complemento', 'cep', 'cidade', 'condominio_id'];

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
