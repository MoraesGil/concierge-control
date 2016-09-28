<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConvidadoRequest extends Request
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
      'nome' => 'required|min:10',
      'pessoa_id' => 'exists:pessoas,id',
    ];
  }

  public function messages()
  {
    return [
      'pessoa_id.*' => 'Pessoa informada nao existe atualize, sua pagina e tente de novamente',       
    ];
  }
}
