<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../services/UserService.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::set('user_service', new UserService());

Flight::group('/users', function() {

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"users"},
     *      summary="Get all users",
     *      @OA\Response(
     *           response=200,
     *           description="Array of all users in the database"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $user_service = Flight::get('user_service');
        Flight::json($user_service->get_all_users());
    });

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      tags={"users"},
     *      summary="Get user by ID",
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
     *           description="User object"
     *      )
     * )
     */
    Flight::route('GET /@id', function($id) {
        $user_service = Flight::get('user_service');
        Flight::json($user_service->get_user_by_id($id));
    });

    /**
     * @OA\Post(
     *      path="/users",
     *      tags={"users"},
     *      summary="Add a new user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username","email","password"},
     *              @OA\Property(property="username", type="string", example="johndoe"),
     *              @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *              @OA\Property(property="password", type="string", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="User added"
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $data = Flight::request()->data->getData();
        $user_service = Flight::get('user_service');
        Flight::json($user_service->add_user($data));
    });

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      tags={"users"},
     *      summary="Update user by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username","email","password"},
     *              @OA\Property(property="username", type="string", example="johndoe"),
     *              @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *              @OA\Property(property="password", type="string", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="User updated"
     *      )
     * )
     */
    Flight::route('PUT /@id', function($id) {
        $data = Flight::request()->data->getData();
        $user_service = Flight::get('user_service');
        $user_service->update_user($id, $data);
        Flight::json(['message' => 'User updated successfully']);
    });

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      tags={"users"},
     *      summary="Delete user by ID",
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
     *           description="User deleted"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id) {
        $user_service = Flight::get('user_service');
        $user_service->delete_user_by_id($id);
        Flight::json(['message' => 'User deleted successfully']);
    });

});
