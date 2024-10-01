<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
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
            'photo_profil' => 'nullable|string|max:255', // Ajout du champ image

            'telephone' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'adress' => 'nullable|string|max:255',
            'commune' => 'nullable|string|max:255',
        ];
    }
}
