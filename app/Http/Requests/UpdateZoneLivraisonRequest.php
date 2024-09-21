<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZoneLivraisonRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'libelle' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'arrondissement_id' => 'sometimes|exists:arrondissements,id',
            'arrondissement2_id' => 'sometimes|exists:arrondissements,id',
        ];
    }
}
