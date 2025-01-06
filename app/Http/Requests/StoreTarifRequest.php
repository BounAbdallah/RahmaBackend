<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Vous pouvez ajouter des logiques d'autorisation ici
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sommes' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'zone_livraison_id' => 'required|exists:zone_livraisons,id',
        ];
    }
}
