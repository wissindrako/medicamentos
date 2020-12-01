<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionPersona extends FormRequest
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
        if ($this->route('id')) {
            return [
                'nombre' => 'required',
                'paterno' => 'required_without:materno',
                'materno' => 'required_without:paterno',
                'cedula_identidad' => 'required|unique:personas' . $this->route('id'),
                'rol' => 'required'
            ];
        } else {
            return [
                'nombre' => 'required',
                'paterno' => 'required_without:materno',
                'materno' => 'required_without:paterno',
                'cedula_identidad' => 'required|unique:personas' . $this->route('id'),
                'rol' => 'required'
            ];
        }
    }
}
