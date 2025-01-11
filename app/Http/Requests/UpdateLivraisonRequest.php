<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLivraisonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'commande_id' => 'sometimes|required|exists:commandes,id',
            'destination' => 'sometimes|required|string|max:255',
            'date_de_livraison' => 'sometimes|required|date',
            'livreur_id' => 'nullable|exists:users,id',
            'gestionnaire_id' => 'nullable|exists:users,id',
            'client_id' => 'nullable|exists:users,id',
            'gp_id' => 'nullable|exists:users,id',
            'zone_livraison_id' => 'sometimes|required|exists:zone_livraisons,id',
        ];
    }
}
