<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ServicoRequest extends Request
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
    switch($this->method())
    {
      case 'GET':
      case 'DELETE':
      {
        return [
        ];
      }
      case 'POST':
      {
        return [
          'nome' => 'required|max:45|min:3|unique:servicos,nome,NULL,id,excluido_em,NULL',
        ];
      }
      case 'PUT':
      case 'PATCH':
      {
        return [
          'nome' => 'required|max:45|min:3|unique:servicos,nome,'.$this->route('id').',id,excluido_em,NULL',
        ];
      }
      default:break;
    }
  }
}
