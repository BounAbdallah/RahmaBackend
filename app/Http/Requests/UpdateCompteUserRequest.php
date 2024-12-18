<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
            'telephone' => 'sometimes|string|max:15',
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|string|exists:roles,name', // Vérifie que le rôle existe dans la table roles
            'adress' => 'nullable|string|max:255',
            'cni' => 'nullable|string|max:255',
            'permis_conduire' => 'nullable|string|max:255',
             'passeport' => 'nullable|string|max:255',
            'date_de_naissance' => 'nullable|date',
             'commune' => 'nullable|string|max:255',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'prenom.sometimes' => 'Le prénom est obligatoire.',
            'nom.sometimes' => 'Le nom est obligatoire.',
            'email.sometimes' => "L'email est obligatoire.",
            'email.unique' => "Cet email est déjà utilisé.",
            'telephone.sometimes' => 'Le téléphone est obligatoire.',
            'password.sometimes' => 'Le mot de passe est obligatoire.',
            'role.exists' => 'Le rôle spécifié est invalide.',
            'adress.nullable' => 'L\'adresse peut être laissée vide.',
            'cni.nullable' => 'La carte d\'identité nationale peut être laissée vide.',
            'permis_conduire.nullable' => 'Le permis de conduire peut être laissé vide.',
             'passeport.nullable' => 'Le passeport peut être laissé vide.',
            'date_de_naissance.nullable' => 'La date de naissance peut être laissée vide.',
            'commune.nullable' => 'La commune peut être laissée vide.',
        ];
    }
}
