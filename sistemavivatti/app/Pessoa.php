<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pessoa extends Model
{
  // id, usuario_id, nome, rg, cpf, cnpj, foto_url, data_nascimento, endereco_id, responsavel_id
  protected $fillable =
  ['usuario_id', 'nome', 'rg', 'cpf', 'cnpj', 'foto_url', 'data_nascimento', 'responsavel_id'];

  protected $appends = ['total_dependentes'];
  protected $hidden = ['dependentes'];

  protected $dates = ['data_nascimento'];


  public $timestamps = false;

  //mutators
  public function getTotalDependentesAttribute()
  {
    return count($this->dependentes);
  }

  public function setDataNascimentoAttribute($value)
  {
    $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
  }

  public function getDataNascimentoAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y');
  }
  //mutators end


  public function sindicos()
  {
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','s')->distinct()->pluck('id'));
  }

  public function porteiros()
  {
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','p')->distinct()->pluck('id'));
  }

  public function moradores()
  {
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','m')->distinct()->pluck('id'));
  }


  public function dependentes()
  {
    return $this->hasMany('App\Pessoa','responsavel_id');
  }

  public function funcionarios()
  {
    return $this->hasMany('App\Pessoa','responsavel_id');
  }
  
  public function responsavel()
  {
    return $this->belongsTo('App\Pessoa','responsavel_id');
  }

  public function contatos()
  {
    return $this->hasOne('App\Contato');
  }

  public function endereco()
  {
    return $this->hasOne('App\Endereco');
  }

  public function usuario()
  {
    return $this->belongsTo('App\Usuario')->withTrashed();
  }
}
