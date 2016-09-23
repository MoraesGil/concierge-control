<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VisitaRequest extends Request
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
      'morador.id' => 'required|exists:pessoas,id',
      'visitante.id' => 'required',
      'visitante.nome' => 'required|min:10',
      'visitante.cpf' =>'required_if:visitante.id,0|cpf|unique:pessoas,cpf,NULL,id',
      'veiculo.id' => 'required',
      'veiculo.placa' => 'min:8|max:8',
    ];
  }

  public function messages()
  {
    return [
      'morador.id.*' => 'É necessário informar um morador cadastrado',
      'veiculo.placa.*' => 'É necessário informar placa válida ex: ATV-0365',
      'visitante.nome.required'=>'É necessário informar o visitante',
      'visitante.cpf.required_if'=>'É necessário informar o cpf para visitante não cadastrado.',
      'visitante.cpf.cpf'=>'É necessário informar um cpf válido.',
    ];
  }
}
