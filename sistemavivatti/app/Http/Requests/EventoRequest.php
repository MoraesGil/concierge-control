<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventoRequest extends Request
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
         'data_entrada' => 'required|date_format:"d/m/Y"',
         'data_saida' => 'required|date_format:"d/m/Y"',
         'data_entrada' => 'required|after:today|date_format:"d/m/Y"',
         'data_saida' => 'required|after:today|date_format:"d/m/Y"',
       ];
     }

     public function messages()
     {
       return [
         'data_entrada.after' => 'Data de entrada deve ser maior ou igual a data de hoje.',
         'data_entrada.date_format' => 'Data de entrada não confere com o formato ex: 12/12/1990',
         'data_saida.after' => 'Data de saída deve ser maior ou igual a data de entrada.',
         'data_saida.date_format' => 'Data de saída não confere com o formato ex: 12/12/1990',
       ];
     }
}
