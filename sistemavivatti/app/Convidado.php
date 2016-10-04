<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convidado extends Model
{
  protected $fillable = ['nome'];

  protected $hidden =[''];

  public $timestamps = false;

  public function pessoa()
  {
    return $this->belongsTo('App\Pessoa');
  }

  public function reserva()
  {
    return $this->belongsTo('App\Reserva');
  }

}
