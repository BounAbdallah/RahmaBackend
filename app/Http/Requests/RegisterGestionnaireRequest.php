<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterGestionnaireRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'adress' => 'nullable|string|max:255',
            'cni' => 'nullable|string|max:20',
            'date_de_naissance' => 'nullable|date',
            'commune' => 'nullable|string|max:255',
        ];
    }
}
