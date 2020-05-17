<?php

namespace App\Http\Requests\Libro;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'titulo' => 'required|max:100',
            'idioma' => 'required',
            'genero' => 'required',
            'autor' => 'required',
            'editorial' => 'required',
            'isbn' => 'required|numeric',
            '_archivo' => 'required|file',
            'descripcion' => 'required|max:200',
            
        ];
    }
}
