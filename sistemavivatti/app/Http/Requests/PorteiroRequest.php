<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PorteiroRequest extends Request
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
             'nome' =>'required',
             'rg' =>'required',
             'cpf' =>'required|cpf|unique:pessoas,cpf,NULL,id',
             'telefone' =>'required',
             'celular' =>'required',
             'cep' =>'required',
             'logradouro' =>'required',
             'numero' =>'required',
             'bairro' =>'required',
             'cidade' =>'required',
             'condominio_id' => 'required|integer|exists:condominios,id'
           ];
         }
         case 'PUT':
         case 'PATCH':
         {
           return [
             'nome' =>'required',
             'rg' =>'required',
             'cpf' =>'required|cpf|unique:pessoas,cpf,'.$this->route('id').',id',
             'telefone' =>'required|min:',
             'celular' =>'required',
             'cep' =>'required',
             'logradouro' =>'required',
             'numero' =>'required',
             'bairro' =>'required',
             'cidade' =>'required',
             'condominio_id' => 'required|integer|exists:condominios,id'
           ];
         }
         default:break;
       }
     }

     public function messages()
     {
       return [
         'cpf.cpf'=>'O campo cpf deve conter um cpf válido'
       ];
     }
}
