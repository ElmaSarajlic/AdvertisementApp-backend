<?php

require __DIR__ . '/../../../vendor/autoload.php';

define('BASE_URL', 'http://localhost/AdvertisementApp/AdvertisementApp-backend/');

// Turn off error reporting
error_reporting(0);

// Correct the paths in the scan method
$openapi = \OpenApi\Generator::scan([__DIR__ . '/../../../rest/routes', __DIR__]);

// Set the header to return JSON instead of YAML
header('Content-Type: application/json');
echo $openapi->toJson();
?>
