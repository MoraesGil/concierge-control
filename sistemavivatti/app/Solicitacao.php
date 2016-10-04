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
    return $this->belongsTo('App\Usuario')->withTrashed();;
  }

  public function getCriadoEmAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
  }
  public function getTipoAttribute($value)
  {
    $tipo_text="oiii";

    switch ($value) {
      case 2:
      $tipo_text = "Reclamação";
      break;
      case 3:
      $tipo_text = "Problemas";
      break;

      default:
      $tipo_text = "Outros";
      break;
    }
    return  $tipo_text;
  }

  public function getFinalizadoEmAttribute($value)
  {
    if ($value) {
      return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
    return null;

  }

  const CREATED_AT = 'criado_em';
  const DELETED_AT = 'finalizado_em';

}
