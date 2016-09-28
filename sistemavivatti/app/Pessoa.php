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

  //mutators
  public function setCpfAttribute($value)
  {
    $this->attributes['cpf'] = $this->mask($value,'###.###.###-##');
  }

  public function setCnpjAttribute($value)
  {
    $this->attributes['cnpj'] = $this->mask($value,'##.###.###/####-##');
  }

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
    return $this->whereIn('usuario_id',
    \DB::table('usuarios')
    ->where('permissao','p')->distinct()->pluck('id'));
  }

  public function moradores($usuarios=true, $condominio = null)
  {
    // lista apenas os moradores usuarios do sistema
    if ($usuarios) {
      return $this->whereHas('usuario', function($q){
        $q->where('permissao', '=', 'm');
      });
    }

    //tras moradores e os respectivos dependentes...
    $moradores_ids =  $this->whereHas('usuario', function($q){
      $q->where('permissao', '=', 'm');
    })->pluck('id');

    $dependentes_ids =  $this->whereHas('responsavel', function($q) use ($moradores_ids)   {
      $q->whereIn('id',$moradores_ids    );
    })->pluck('id');

    $moradores_ids = array_collapse([$moradores_ids,$dependentes_ids]);

    return $this->whereIn('id',$moradores_ids);

  }
  //filtro por usuario


  //filtro visitantes
  public function visitantes($condominio = null)
  {
    $moradores_ids = $this->moradores(false)->pluck('id');
    $porteiros_ids = $this->porteiros()->pluck('id');
    $sindicos_ids = $this->sindicos()->pluck('id');
    $todos = array_collapse([$moradores_ids,$porteiros_ids,$sindicos_ids]);

    return $this->whereNotIn('id',$todos);
  }


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

  public function getTotalServicosAttribute()
  {
    return count($this->servicos_prestados);
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
    return $this->belongsToMany('App\Veiculo','usuarios_veiculo','pessoa_id','veiculo_id');
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


  public function visitas()
  {
    return $this->hasMany('App\Visita','morador_id');
  }

  public function usuario()
  {
    return $this->belongsTo('App\Usuario')->withTrashed();
  }

  // http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
  private function mask($val, $mask)
  {
    $val = str_replace(".","",$val);
    $val = str_replace("-","",$val);

    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
      if($mask[$i] == '#')
      {
        if(isset($val[$k]))
        $maskared .= $val[$k++];
      }
      else
      {
        if(isset($mask[$i]))
        $maskared .= $mask[$i];
      }
    }

    return $maskared;
  }


}
