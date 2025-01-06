<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
{
    public function authorize()
    {
        // Autorise cette requête à tous les utilisateurs
        return true;
    }

    public function rules()
    {
        return [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',  // Attend 'password_confirmation'
            'photo_profil' => 'nullable|string|max:255',// Ajout du champ image

        ];
    }
}
