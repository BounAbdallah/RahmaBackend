<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreZoneLivraisonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assure-toi que la gestion des autorisations est en place
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'arrondissement_id' => 'required|exists:arrondissements,id', // Assure-toi que l'arrondissement existe
            'arrondissement2_id' => 'required|exists:arrondissements,id', // Assure-toi que l'arrondissement existe
        ];
    }
}
