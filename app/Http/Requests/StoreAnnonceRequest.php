<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnonceRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Assurez-vous que l'utilisateur est autorisé à faire cette demande
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titre' => 'required|string|max:255',
            'pays_provenance' => 'required|string|max:100',
            'pays_destination' => 'required|string|max:100',
            'photo_pays_voyage_provenance' => 'required|url',
            'photo_pays_voyage_destination' => 'required|url',
            'date_debut_reception_colis' => 'required|date_format:Y-m-d H:i:s',
            'date_fin_reception_colis' => 'required|date_format:Y-m-d H:i:s|after:date_debut_reception_colis',
            'description' => 'required|string|max:500',
            'condition' => 'nullable|string|max:500',
            'statut' => 'required|in:active,inactif',
            'poids_kg' => 'required|numeric|min:1|max:100',
            'pays_provenance_voyage' => 'required|string|max:100',
            'region_provenance_voyage' => 'required|string|max:100',
            'pays_destination_voyage' => 'required|string|max:100',
            'region_destination_voyage' => 'required|string|max:100',
            'date_prevue_voyage' => 'required|date_format:Y-m-d',
            'heure_prevue_voyage' => 'required|date_format:H:i:s',
            'heure_debut_reception_colis' => 'required|date_format:H:i:s',
            'heure_fin_reception_colis' => 'required|date_format:H:i:s|after:heure_debut_reception_colis',
            'prix_par_kg' => 'required|numeric|min:0',
        ];
    }
}
