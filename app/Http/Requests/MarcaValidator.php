<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaValidator extends FormRequest
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
                'nome' => 'required|unique:marcas,nome,' . $this->route("marca"),
                'imagem' => 'required'
            ];
        }
    }
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'Esse nome já está atribuido a um outro registro'
        ];
    }
}
