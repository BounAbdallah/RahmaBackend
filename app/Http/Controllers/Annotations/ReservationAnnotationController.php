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
 *     path="/api/reservations/{id}/status",
 *     summary="ModifierReservation",
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
 *                     @OA\Property(property="annonce_id", type="integer"),
 *                     @OA\Property(property="user_id", type="integer"),
 *                     @OA\Property(property="status", type="string"),
 *                     @OA\Property(property="date_reservation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Reservation"},
*),


 * @OA\POST(
 *     path="/api/reservations/",
 *     summary="CreerReservation",
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
 *                     @OA\Property(property="annonce_id", type="integer"),
 *                     @OA\Property(property="user_id", type="integer"),
 *                     @OA\Property(property="status", type="string"),
 *                     @OA\Property(property="date_reservation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Reservation"},
*),


 * @OA\PUT(
 *     path="/api/client/reservation/{id}",
 *     summary="Details reservation",
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
 *                     @OA\Property(property="annonce_id", type="integer"),
 *                     @OA\Property(property="user_id", type="integer"),
 *                     @OA\Property(property="status", type="string"),
 *                     @OA\Property(property="date_reservation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Reservation"},
*),


 * @OA\GET(
 *     path="/api/reservations",
 *     summary="ListeReservation",
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
 *                     @OA\Property(property="annonce_id", type="integer"),
 *                     @OA\Property(property="user_id", type="integer"),
 *                     @OA\Property(property="status", type="string"),
 *                     @OA\Property(property="date_reservation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Reservation"},
*),


 * @OA\DELETE(
 *     path="/api/reservations/{id}",
 *     summary="SupprimerReservation",
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
 *     tags={"Reservation"},
*),


*/

 class ReservationAnnotationController {}
