<?php
// Report all errors accept E_NOTICE
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

// Database access credentials
define('DB_NAME', 'advertisementappdb');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', '127.0.0.1');

//Jwt secret key

define('JWT_SECRET', 'JCFS6IEZl1TQzDGUoCm4RHH4NOT3Nh');