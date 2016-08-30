<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
  protected $fillable = ['permissao', 'login', 'senha'];

  protected $hidden = ['senha','remember_token'];

  public function dados_pessoais()
  {
    return $this->hasOne('App\Pessoa');
  }

  use SoftDeletes;
  const CREATED_AT = 'criado_em';
  const UPDATED_AT = 'atualizado_em';
  const DELETED_AT = 'desativado_em';

}
