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

 * @OA\POST(
 *     path="/api/annonces/{id}/restore",
 *     summary="DesarchiveAnnonce",
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
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


 * @OA\DELETE(
 *     path="/api/annonces/{id}/archive",
 *     summary="ArchiveAnnonce",
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
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


 * @OA\PUT(
 *     path="/api/annonces/{id}",
 *     summary="ModificationAnnonce",
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
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


 * @OA\GET(
 *     path="/api/annonces/{id}",
 *     summary="DetailsAnnonce",
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
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


 * @OA\POST(
 *     path="/api/CreationAnnonces/",
 *     summary="CreerUneAnnonce",
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
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


 * @OA\GET(
 *     path="/api/ListeAnnonces/",
 *     summary="Liste Annonce",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Annonces"},
*),


 * @OA\GET(
 *     path="/api/GpDisponible",
 *     summary="Liste Annonce Disponible",
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
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


 * @OA\GET(
 *     path="/api/detailsAnnoceGP/{id}",
 *     summary="Details Annonce GP Disponible",
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
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="date_debut_reception_colis", type="string"),
 *                     @OA\Property(property="date_fin_reception_colis", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="tarif", type="integer"),
 *                     @OA\Property(property="condition", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Annonces"},
*),


*/

 class AnnoncesAnnotationController {}
