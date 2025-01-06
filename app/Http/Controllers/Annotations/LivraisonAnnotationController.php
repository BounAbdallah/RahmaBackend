<?php

namespace App\Http\Controllers\Annotations ;

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),

 *

 * @OA\GET(
 *     path="/api/livraisons",
 *     summary="ListeLivraison",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Livraison"},
*),


 * @OA\POST(
 *     path="/api/livraisons",
 *     summary="AjouterLivraison",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="destination", type="string"),
 *                     @OA\Property(property="date_de_livraison", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="livreur_id", type="integer"),
 *                     @OA\Property(property="gestionnaire_id", type="integer"),
 *                     @OA\Property(property="client_id", type="integer"),
 *                     @OA\Property(property="gp_id", type="integer"),
 *                     @OA\Property(property="colis_id", type="integer"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Livraison"},
*),


 * @OA\PUT(
 *     path="/api/livraisons/{id}",
 *     summary="ModifierLivraison",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="destination", type="string"),
 *                     @OA\Property(property="date_de_livraison", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="livreur_id", type="integer"),
 *                     @OA\Property(property="gestionnaire_id", type="integer"),
 *                     @OA\Property(property="client_id", type="integer"),
 *                     @OA\Property(property="gp_id", type="integer"),
 *                     @OA\Property(property="colis_id", type="integer"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Livraison"},
*),


 * @OA\DELETE(
 *     path="/api/livraisons/{id}",
 *     summary="SupprimerLivraison",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="destination", type="string"),
 *                     @OA\Property(property="date_de_livraison", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="livreur_id", type="integer"),
 *                     @OA\Property(property="gestionnaire_id", type="integer"),
 *                     @OA\Property(property="client_id", type="integer"),
 *                     @OA\Property(property="gp_id", type="integer"),
 *                     @OA\Property(property="colis_id", type="integer"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Livraison"},
*),


*/

 class LivraisonAnnotationController {}
