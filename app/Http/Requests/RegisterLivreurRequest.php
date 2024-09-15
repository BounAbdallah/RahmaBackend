<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterLivreurRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Vous pouvez ajouter une logique d'autorisation si nécessaire
    }

    public function rules()
    {
        return [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'adress' => 'nullable|string|max:255',
            'cni' => 'nullable|string|max:255',
            'permis_conduire' => 'nullable|string|max:255',
            'date_de_naissance' => 'nullable|date',
            'commune' => 'nullable|string|max:255',
        ];
    }
}
