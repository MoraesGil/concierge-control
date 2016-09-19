<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
  protected $fillable =
  ['nome'];

  // protected $hidden =['pivot'];

  protected $appends = ['fornecedores_total'];


  public $timestamps = false;

  public function fornecedores()
  {
    return $this->belongsToMany('App\Pessoa', 'servicos_prestador', 'servico_id','pessoa_id');
  }

  //mutators
  public function getFornecedoresTotalAttribute()
  {
    return \DB::table('servicos_prestador')->where('servico_id',$this->id)->count();
  }



}
