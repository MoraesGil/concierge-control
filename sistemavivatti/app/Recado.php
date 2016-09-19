<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recado extends Model
{

  protected $fillable = ['usuario_id', 'titulo', 'descricao'];

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
}
