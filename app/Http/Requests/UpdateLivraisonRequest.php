<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLivraisonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // À modifier selon les besoins d'autorisation
    }

    public function rules(): array
    {
        return [
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'destination' => 'sometimes|required|string|max:255',
            'date_de_livraison' => 'sometimes|required|date',
            'statut' => 'sometimes|required|string|max:255',
            'livreur_id' => 'nullable|exists:users,id',
            'gestionnaire_id' => 'nullable|exists:users,id',
            'client_id' => 'nullable|exists:users,id',
            'gp_id' => 'nullable|exists:users,id',
            'colis_id' => 'sometimes|required|exists:colis,id',
            'zone_livraison_id' => 'sometimes|required|exists:zone_livraisons,id',
        ];
    }
}
