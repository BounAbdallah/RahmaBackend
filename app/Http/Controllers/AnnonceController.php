<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $annonces = Annonce::all();
        return response()->json($annonces);
    }
    public function annoceDisponible(){
        $annonces = Annonce::where('statut', 'active')->get();
        return response()->json($annonces);
    }

    public function detailAnnonceDisponible($id){
        $annonces = Annonce::where('statut', 'active')->where('id', $id)->get();
        return response()->json($annonces);
    }

    public function show($id)
    {
        $annonce = Annonce::findOrFail($id);
        return response()->json($annonce);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|string',
            'titre' => 'required|string',
            'date_debut_reception_colis' => 'required|date',
            'date_fin_reception_colis' => 'required|date',
            'description' => 'required|string',
            'tarif' => 'required|numeric',
            'condition' => 'required|string',
            'statut' => 'required|in:active,expirée',
            'poids_kg' => 'required|numeric',
        ]);

        $validatedData['createur'] = Auth::user()->id;
        $annonce = Annonce::create($validatedData);

        return response()->json([
        "Annonce" => $annonce,
        "Createur" => $annonce->createur
        ],201);
    }

    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);

        if ($annonce->createur != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'image' => 'nullable|string',
            'titre' => 'sometimes|required|string',
            'date_debut_reception_colis' => 'sometimes|required|date',
            'date_fin_reception_colis' => 'sometimes|required|date',
            'description' => 'sometimes|required|string',
            'tarif' => 'sometimes|required|numeric',
            'condition' => 'sometimes|required|string',
            'statut' => 'sometimes|required|in:active,expirée',
            'poids_kg' => 'sometimes|required|numeric',
        ]);

        $annonce->update($validatedData);

        return response()->json($annonce);
    }

    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);

        if ($annonce->createur != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $annonce->delete();

        return response()->json(['message' => 'Annonce archived']);
    }

    public function forceDelete($id)
    {
        $annonce = Annonce::withTrashed()->findOrFail($id);

        if ($annonce->createur != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $annonce->forceDelete();

        return response()->json(['message' => 'Annonce permanently deleted']);
    }
}
