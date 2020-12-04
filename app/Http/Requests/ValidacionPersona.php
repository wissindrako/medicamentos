<?php

namespace App\Http\Requests;

use App\Persona;
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
            $persona = Persona::findOrFail($this->route('id'));
            return [
                'nombre' => 'required',
                'paterno' => 'required_without:materno',
                'materno' => 'required_without:paterno',
                'cedula_identidad' => 'required|unique:users,email,' . $persona->usuario->id,
                'telefono_celular' => 'required',
                'rol' => 'required'
            ];
        } else {
            return [
                'nombre' => 'required',
                'paterno' => 'required_without:materno',
                'materno' => 'required_without:paterno',
                'cedula_identidad' => 'required|unique:personas,cedula_identidad',
                'telefono_celular' => 'required',
                'rol' => 'required'
            ];
        }
    }
}
