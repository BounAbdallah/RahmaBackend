<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZoneLivraisonRequest;
use App\Http\Requests\UpdateZoneLivraisonRequest;
use App\Models\ZoneLivraison;
use Illuminate\Http\Request;



class ZoneLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   // Récupère toutes les zones
        $zonesLivraison = ZoneLivraison::all();
        return response()->json($zonesLivraison);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZoneLivraisonRequest $request)
    {
        $zoneLivraison = ZoneLivraison::create($request->validated());
        return response()->json(['message' => 'Zone de livraison créée avec succès', 'zoneLivraison' => $zoneLivraison]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ZoneLivraison $zoneLivraison)
    {
        return response()->json($zoneLivraison);
    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, ZoneLivraison $zoneLivraison)
{
    // Validation des données
    $request->validate([
        'libelle' => 'required|string|max:255',
        'description' => 'nullable|string',
        'arrondissement_id' => 'required|exists:arrondissements,id',
        'arrondissement2_id' => 'required|exists:arrondissements,id',
    ]);

    // Mise à jour de la zone de livraison
    $zoneLivraison->update($request->all());

    return response()->json([
        'message' => 'Zone de livraison mise à jour avec succès',
        'zoneLivraison' => $zoneLivraison
    ]);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZoneLivraison $zoneLivraison)
    {
        $zoneLivraison->delete();
        return response()->json(['message' => 'Zone de livraison supprimée avec succès']);
    }
}
