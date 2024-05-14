<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../services/AdService.class.php';

Flight::set('ad_service', new AdService());

Flight::group('/ads', function() {

    /**
     * @OA\Get(
     *      path="/ads",
     *      tags={"ads"},
     *      summary="Get all ads",
     *      @OA\Response(
     *           response=200,
     *           description="Array of all ads in the database"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $ad_service = Flight::get('ad_service');
        Flight::json($ad_service->get_all_ads());
    });

    /**
     * @OA\Get(
     *      path="/ads/{id}",
     *      tags={"ads"},
     *      summary="Get ad by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Ad object"
     *      )
     * )
     */
    Flight::route('GET /@id', function($id) {
        $ad_service = Flight::get('ad_service');
        Flight::json($ad_service->get_ad_by_id($id));
    });

    /**
     * @OA\Post(
     *      path="/ads",
     *      tags={"ads"},
     *      summary="Add a new ad",
     *      @OA\RequestBody(
     *          description="Ad data",
     *          required=true,
     *          @OA\JsonContent(
     *              required={"imgUrl", "title", "description", "dateOfCreation", "categoryId"},
     *              @OA\Property(property="imgUrl", type="string", example="https://example.com/img.jpg"),
     *              @OA\Property(property="title", type="string", example="Ad Title"),
     *              @OA\Property(property="description", type="string", example="Ad Description"),
     *              @OA\Property(property="dateOfCreation", type="string", format="date-time", example="2024-05-14T10:00:00Z"),
     *              @OA\Property(property="categoryId", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Ad added"
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $data = Flight::request()->data->getData();
        $ad_service = Flight::get('ad_service');
        Flight::json($ad_service->add_ad($data));
    });

    /**
     * @OA\Put(
     *      path="/ads/{id}",
     *      tags={"ads"},
     *      summary="Update ad by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Ad data",
     *          required=true,
     *          @OA\JsonContent(
     *              required={"imgUrl", "title", "description", "dateOfCreation", "categoryId"},
     *              @OA\Property(property="imgUrl", type="string", example="https://example.com/img.jpg"),
     *              @OA\Property(property="title", type="string", example="Ad Title"),
     *              @OA\Property(property="description", type="string", example="Ad Description"),
     *              @OA\Property(property="dateOfCreation", type="string", format="date-time", example="2024-05-14T10:00:00Z"),
     *              @OA\Property(property="categoryId", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Ad updated"
     *      )
     * )
     */
    Flight::route('PUT /@id', function($id) {
        $data = Flight::request()->data->getData();
        $ad_service = Flight::get('ad_service');
        $ad_service->update_ad($id, $data);
        Flight::json(['message' => 'Ad updated successfully']);
    });

    /**
     * @OA\Delete(
     *      path="/ads/{id}",
     *      tags={"ads"},
     *      summary="Delete ad by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Ad deleted"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id) {
        $ad_service = Flight::get('ad_service');
        $ad_service->delete_ad_by_id($id);
        Flight::json(['message' => 'Ad deleted successfully']);
    });

});
