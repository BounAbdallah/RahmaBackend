<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLivraisonRequest;
use App\Http\Requests\UpdateLivraisonRequest;
use App\Models\Livraison;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livraisons = Livraison::all();
        return response()->json($livraisons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLivraisonRequest $request)
    {
        // Utiliser les données validées pour créer une livraison
        $livraison = Livraison::create($request->validated());

        return response()->json(['message' => 'Livraison créée avec succès', 'livraison' => $livraison], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Livraison $livraison)
    {
        return response()->json($livraison);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLivraisonRequest $request, Livraison $livraison)
    {
        // Utiliser les données validées pour mettre à jour la livraison
        $livraison->update($request->validated());

        return response()->json(['message' => 'Livraison mise à jour avec succès', 'livraison' => $livraison]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livraison $livraison)
    {
        $livraison->delete();
        return response()->json(['message' => 'Livraison supprimée avec succès']);
    }
}
