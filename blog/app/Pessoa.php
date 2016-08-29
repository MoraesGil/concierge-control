<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
  // id, usuario_id, nome, rg, cpf, cnpj, foto_url, data_nascimento, endereco_id, responsavel_id
  protected $fillable =
  ['usuario_id', 'nome', 'rg', 'cpf', 'cnpj', 'foto_url', 'data_nascimento', 'responsavel_id', 'fornecedor_id'];

  public $timestamps = false;


  public function dependentes()
  {
    return $this->hasMany('App\Pessoa','responsavel_id');
  } 

  public function contatos()
  {
    return $this->hasOne('App\Contato');
  }

  public function endereco()
  {
    return $this->hasOne('App\Endereco');
  }

}
