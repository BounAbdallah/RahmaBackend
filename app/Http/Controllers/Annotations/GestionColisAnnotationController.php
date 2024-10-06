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
 *     path="/api/colis",
 *     summary="Liste colis",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"GestionColis"},
*),


 * @OA\POST(
 *     path="/api/colis",
 *     summary="Ajouter colis",
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
 *                     @OA\Property(property="image_1", type="string"),
 *                     @OA\Property(property="image_2", type="string"),
 *                     @OA\Property(property="image_3", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                     @OA\Property(property="adresse_expediteur", type="string"),
 *                     @OA\Property(property="adresse_destinataire", type="string"),
 *                     @OA\Property(property="contact_destinataire", type="string"),
 *                     @OA\Property(property="contact_expediteur", type="string"),
 *                     @OA\Property(property="date_envoi", type="string"),
 *                     @OA\Property(property="date_reception", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"GestionColis"},
*),


 * @OA\GET(
 *     path="/api/colis/{id}",
 *     summary="details colis",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"GestionColis"},
*),


 * @OA\PATCH(
 *     path="/api/colis/{id}",
 *     summary="Modifier colis",
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
 *                     @OA\Property(property="image_1", type="string"),
 *                     @OA\Property(property="image_2", type="string"),
 *                     @OA\Property(property="image_3", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                     @OA\Property(property="adresse_expediteur", type="string"),
 *                     @OA\Property(property="adresse_destinataire", type="string"),
 *                     @OA\Property(property="contact_destinataire", type="string"),
 *                     @OA\Property(property="contact_expediteur", type="string"),
 *                     @OA\Property(property="date_envoi", type="string"),
 *                     @OA\Property(property="date_reception", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"GestionColis"},
*),


 * @OA\DELETE(
 *     path="/api/colis/{id}",
 *     summary="Archiver un colis",
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
 *                     @OA\Property(property="image_1", type="string"),
 *                     @OA\Property(property="image_2", type="string"),
 *                     @OA\Property(property="image_3", type="string"),
 *                     @OA\Property(property="poids_kg", type="integer"),
 *                     @OA\Property(property="adresse_expediteur", type="string"),
 *                     @OA\Property(property="adresse_destinataire", type="string"),
 *                     @OA\Property(property="contact_destinataire", type="string"),
 *                     @OA\Property(property="contact_expediteur", type="string"),
 *                     @OA\Property(property="date_envoi", type="string"),
 *                     @OA\Property(property="date_reception", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="user_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"GestionColis"},
*),


*/

 class GestionColisAnnotationController {}
