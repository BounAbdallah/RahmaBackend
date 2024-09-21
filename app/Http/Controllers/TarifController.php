<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTarifRequest;
use App\Http\Requests\UpdateTarifRequest;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifs = Tarif::all(); // Récupérer tous les tarifs
        return response()->json($tarifs, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTarifRequest $request)
    {
        // Validation via StoreTarifRequest (qui doit être défini)
        $tarif = Tarif::create($request->validated()); // Créer un tarif avec les données validées
        return response()->json($tarif, 201); // Réponse avec statut 201 (créé)
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarif $tarif)
    {
        return response()->json($tarif, 200); // Afficher un tarif spécifique
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTarifRequest $request, Tarif $tarif)
    {
        // Validation via UpdateTarifRequest (qui doit être défini)
        $tarif->update($request->validated()); // Mettre à jour les données du tarif
        return response()->json($tarif, 200); // Réponse avec le tarif mis à jour
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarif $tarif)
    {
        $tarif->delete(); // Suppression avec soft delete
        return response()->json(null, 204); // Réponse vide avec statut 204 (pas de contenu)
    }
}
