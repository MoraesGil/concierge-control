<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SolicitacaoRequest extends Request
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
    {//  ['usuario_id', 'anonimo', 'tipo', 'prioridade','descricao','titulo', 'finalizado_em'];
      return [
        'anonimo'=>'required|boolean',
        'tipo'=>'required|in:1,2,3',
        'prioridade'=>'required|in:0,1,2',
        'titulo' => 'required|max:45|min:3',
        'descricao' => 'required|max:1000|min:10',
      ];
    }

    public function messages()
    {
      return [
        'tipo.in'=> 'Tipos aceitos cod: 1 = Outros 2 = Reclamação 3 = problemas',
        'prioridade.in'=> 'Prioridades 1 = normal, 2 = média e 3 = alta',
      ];
    }
}
