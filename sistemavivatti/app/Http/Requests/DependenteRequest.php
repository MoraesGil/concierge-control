<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DependenteRequest extends Request
{
  /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    return true;
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules()
  {
    return [
      'nome' =>'required|min:3',
      'rg' =>'required|min:9',
      'data_nascimento' =>'required|date_format:"d/m/Y"',
    ];
  }
  public function messages()
  {
    return [
      'data_nascimento.date_format' => 'Informe dia mês e ano ex: 12/12/1990 ', 
    ];
  }

}
