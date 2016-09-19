<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitacao extends Model
{
  use SoftDeletes;
  protected $table ='solicitacoes';

  protected $fillable = ['usuario_id', 'anonimo', 'tipo', 'prioridade','descricao','titulo', 'finalizado_em'];

  protected $hidden =[''];

  public $timestamps = false;


  public function usuario()
  {
    return $this->belongsTo('App\Usuario');
  }

  public function getCriadoEmAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
  }

  const CREATED_AT = 'criado_em';
  const DELETED_AT = 'finalizado_em';

}
