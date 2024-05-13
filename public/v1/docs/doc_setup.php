<?php

/**
 * @OA\Info(
 *   title="API",
 *   description="Advertisement App",
 *   version="1.0",
 *   @OA\Contact(
 *     email="elma.sarajlic@stu.ibu.edu.ba",
 *     name="Elma Sarajlic"
 *   )
 * ),
 * @OA\OpenApi(
 *   @OA\Server(
 *       url=BASE_URL
 *   )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */