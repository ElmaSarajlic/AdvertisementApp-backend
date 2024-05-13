<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../services/UserService.class.php';
require_once __DIR__ . '/../services/AuthService.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::set('user_service', new UserService());
Flight::set('auth_service', new AuthService());

Flight::group('/auth', function() {

    /**
     * @OA\Post(
     *      path="/auth/register",
     *      tags={"auth"},
     *      summary="Register a new user",
     *      @OA\RequestBody(
     *          description="User registration data",
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username","email","password"},
     *              @OA\Property(property="username", type="string", example="johndoe"),
     *              @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *              @OA\Property(property="password", type="string", example="password123"),
     *              @OA\Property(property="imgUrl", type="string", example="http://example.com/avatar.jpg")
     *          )
     *      ),
     *      @OA\Response(
     *           response=201,
     *           description="User registered successfully",
     *           @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *           response=400,
     *           description="Missing or invalid parameter"
     *      )
     * )
     */
    Flight::route('POST /register', function () {
        $data = Flight::request()->data->getData();

        $data = array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $data);

        foreach ($data as $key => $value) {
            if (empty($value) && $key != 'imgUrl') {
                Flight::halt(400, "Missing or invalid parameter: $key");
                return;
            }
        }

        $user_service = Flight::get('user_service');
        $user = $user_service->add_user($data);
        if ($user) {
            Flight::json($user, 201);
        } else {
            Flight::halt(400, "User could not be registered");
        }
    });

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system",
     *      @OA\Response(
     *           response=200,
     *           description="User data and JWT token"
     *      ),
     *      @OA\RequestBody(
     *          description="User credentials",
     *          @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", required=true, type="string", example="elma.sarajlic@ibu.edu.ba"),
     *             @OA\Property(property="password", required=true, type="string", example="pass")
     *           )
     *      ),
     * )
     */
    Flight::route('POST /login', function() {
        $payload = Flight::request()->data->getData();
        $user = Flight::get('auth_service')->get_user_by_email($payload['email']);

        if (!$user || !password_verify($payload['password'], $user['password'])) {
            Flight::halt(500, "Invalid username or password");
        }

        unset($user['password']); 
        $payload = [
            'user' => $user,
            'iat' => time(), 
            'exp' => time() + 100000 
        ];

        $token = JWT::encode(
            $payload, 
            JWT_SECRET, 
            'HS256'
        );

        Flight::json([
            'user' => array_merge($user, ['token' => $token]),
            'token' => $token
        ]);
    });

    /**
     * @OA\Post(
     *      path="/auth/logout",
     *      tags={"auth"},
     *      summary="Logout from system",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success response or exception"
     *      ),
     * )
     */
    Flight::route('POST /logout', function() {
        try {
            $token = Flight::request()->getHeader('Authentication');
            if ($token) {
                $decoded_token = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
                Flight::json([
                    'jwt_decoded' => $decoded_token,
                    'user' => $decoded_token->user
                ]);
            }
        } catch (\Exception $e) {
            Flight::halt(500, $e->getMessage());
        }            
    });
});
