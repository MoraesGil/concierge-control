<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
  //id, usuario_id, email, telefone, celular

  protected $fillable = ['usuario_id','email', 'telefone', 'celular'];

  public $timestamps = false;
}
