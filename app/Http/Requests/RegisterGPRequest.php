<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterGPRequest extends FormRequest
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
            'pays_de_voyage' => 'nullable|string|max:255',
            'region_de_voyage' => 'nullable|string|max:255',
            'passeport' => 'nullable|string|max:255',
            'date_de_naissance' => 'nullable|date',
            'prix_kg' => 'nullable|numeric',
            'commune' => 'nullable|string|max:255',
        ];
    }
}
