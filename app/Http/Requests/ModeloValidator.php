<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModeloValidator extends FormRequest
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
        if ($this->method() == "PATCH") {
            return [
                'nome' => '|unique:marcas,nome,' . $this->route("marca")
            ];
        } else {

            return [
                'marca_id' => 'exists:marcas,id',
                'nome' => 'required|unique:marcas,nome,' . $this->route("marca"),
                'imagem' => 'required|file|mimes:png,jpeg,jpg',
                'numero_portas' => 'required|integer|digits_between:1,5',
                'lugares' => 'required|integer|digits_between:1,20',
                'air_bag' => 'required|boolean',
                'abs' => 'required|boolean',
            ];
        }
    }
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'Esse nome já está atribuido a um outro registro',
            'imagem.mimes' => 'O arquivo precisa ser uma imagem do tipo PNG'
        ];
    }
}
