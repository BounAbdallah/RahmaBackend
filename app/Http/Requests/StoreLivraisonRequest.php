<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivraisonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'commande_id' => 'required|exists:commandes,id',
            'destination' => 'required|string|max:255',
            'date_de_livraison' => 'required|date',
            'livreur_id' => 'nullable|exists:users,id',
            'gestionnaire_id' => 'nullable|exists:users,id',
            'client_id' => 'nullable|exists:users,id',
            'gp_id' => 'nullable|exists:users,id',
            'zone_livraison_id' => 'required|exists:zone_livraisons,id',
        ];
    }
}
