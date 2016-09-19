<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pessoa extends Model
{
  // id, usuario_id, nome, rg, cpf, cnpj, foto_url, data_nascimento, endereco_id, responsavel_id
  protected $fillable =
  ['usuario_id', 'nome', 'rg', 'cpf', 'cnpj', 'foto_url', 'data_nascimento', 'responsavel_id'];


  protected $hidden = ['dependentes'];

  protected $dates = ['data_nascimento'];


  public $timestamps = false;


  ////mutators
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
  ////mutators end

  //filtro por usuario
  public function sindicos($condominio = null)
  {
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','s')->distinct()->pluck('id'));
  }

  public function porteiros($condominio = null)
  {
    if ($condominio) {
      # code...
    }
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','p')->distinct()->pluck('id'));
  }

  public function moradores($condominio = null)
  {
    if ($condominio) {
      # code...
    }
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','m')->distinct()->pluck('id'));
  }
  //filtro por usuario


  //prestadores de servicos

  public function prestadores()
  {
    return $this->whereIn('id',
    \DB::table('servicos_prestador')->distinct()->pluck('pessoa_id'));
  }
  public function servicos_prestados(){
    return $this->belongsToMany('App\Servico','servicos_prestador',
    'pessoa_id', 'servico_id');
  }

  public function avaliacoes(){
    return $this->belongsToMany('App\Usuario','avaliacao_prestador',
    'pessoa_id', 'usuario_id')->withPivot('nota');
  }

  public function getNotaUsuario($usuario_id){
    $usuario = $this->avaliacoes()->where('usuario_id', $usuario_id)->first();
    return $usuario ? $usuario->pivot->nota : 0;
  }

  public function getMediaAvaliacoesAttribute()
  {
    $media = \DB::table('avaliacao_prestador')
    ->where('pessoa_id', $this->id)
    ->avg('nota');
    return round($media*2)/2;
  }

  //prestadores de servicos
  public function veiculos()
  {
    return $this->hasMany('App\Veiculo','responsavel_id');
  }

  //filhos ou funcionarios
  public function dependentes()
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
