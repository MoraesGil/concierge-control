<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RecadoRequest extends Request
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
        'titulo' => 'required|max:45|min:3',
        'descricao' => 'required|max:1000|min:10',
      ];
    }
}
