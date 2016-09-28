<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MaddHatter\LaravelFullcalendar\Event;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Evento extends Model implements Event
{
  // use SoftDeletes;


  protected $fillable = ['data_entrada', 'data_saida', 'usuario_id'];

  protected $hidden = ['convidados'];

  public function setDataEntradaAttribute($value)
  {
    $this->attributes['data_entrada'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
  }

  public function setDataSaidaAttribute($value)
  {
    $this->attributes['data_saida'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
  }

  public function getDataEntradaAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y');
  }

  public function getDataSaidaAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y');
  }

  public function convidados()
  {
    return $this->hasMany('App\Convidado');
  }

  public function usuario()
  {
    return $this->belongsTo('App\Usuario');
  }

  const CREATED_AT = 'criado_em';
  const UPDATED_AT = 'atualizado_em';
  // const DELETED_AT = 'cancelada_em';

  protected $dates = ['data_entrada', 'data_saida'];
  /**
  * Get the event's title
  *
  * @return string
  */
  public function getTitle()
  {
    return $this->usuario->dados_pessoais->nome;
  }
  /**
  * Is it an all day event?
  *
  * @return bool
  */
  public function isAllDay()
  {
    return false;
  }
  /**
  * Get the start time
  *
  * @return DateTime
  */
  public function getStart()
  {
    return Carbon::createFromFormat('d/m/Y', $this->data_entrada);
  }
  /**
  * Get the end time
  *
  * @return DateTime
  */
  public function getEnd()
  {
    return Carbon::createFromFormat('d/m/Y', $this->data_saida);
  }
  /**
  * Get the event's ID
  *
  * @return int|string|null
  */
  public function getId()
  {
    return $this->id;
  }
  /**
  * Optional FullCalendar.io settings for this event
  *
  * @return array
  */
  public function getEventOptions()
  {
    return [
      'color' => $this->background_color,
    ];
  }

  // return true of allowed
  public function data_disponivel($data_entrada,$data_saida,$id = null){
    // $data_entrada = '2016-09-01';
    // $data_saida = '2016-09-24';

    $data_entrada = Carbon::createFromFormat('d/m/Y', $data_entrada)->toDateString();
    $data_saida =  Carbon::createFromFormat('d/m/Y', $data_saida)->toDateString();

    if ($id!=null) {
    //edicao
      return count(\DB::select('SELECT id FROM eventos
        WHERE id != ? and (
        ?   BETWEEN data_entrada AND data_saida
        or
        ?  BETWEEN data_entrada AND data_saida)',
        [$id,$data_entrada,$data_saida])) == 0;
    }
 
    return count(\DB::select('SELECT id FROM eventos
      WHERE
      ?   BETWEEN data_entrada AND data_saida
      or
      ?  BETWEEN data_entrada AND data_saida ',
      [$data_entrada,$data_saida])) == 0;
    }
  }
