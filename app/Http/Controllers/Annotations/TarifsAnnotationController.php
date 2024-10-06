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
 *     path="/api/tarifs",
 *     summary="AjouterTarifs",
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
 *                     @OA\Property(property="sommes", type="integer"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Tarifs"},
*),


 * @OA\GET(
 *     path="/api/tarifs",
 *     summary="ListeTarifs",
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
 *                     @OA\Property(property="sommes", type="integer"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Tarifs"},
*),


 * @OA\GET(
 *     path="/api/tarifs/{id}",
 *     summary="DetailsTarifs",
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
 *                     @OA\Property(property="sommes", type="integer"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Tarifs"},
*),


 * @OA\DELETE(
 *     path="/api/tarifs/{id}",
 *     summary="SupprimerTarifs",
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
 *     tags={"Tarifs"},
*),


 * @OA\PUT(
 *     path="/api/tarifs/{id}",
 *     summary="ModificationTarifs",
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
 *                     @OA\Property(property="sommes", type="integer"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="zone_livraison_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Tarifs"},
*),


*/

 class TarifsAnnotationController {}
