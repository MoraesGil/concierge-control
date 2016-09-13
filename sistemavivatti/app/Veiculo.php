<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
  // id, pessoa_id, placa
  protected $fillable = ['placa'];

  public $timestamps = false;

}
