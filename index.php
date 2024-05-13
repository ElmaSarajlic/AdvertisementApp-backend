<?php

require 'vendor/autoload.php';
require 'rest/config.php';
require 'rest/routes/user_routes.php';
require_once 'rest/routes/auth_routes.php';
require 'rest/routes/comment_routes.php';
require 'rest/routes/category_routes.php';





Flight::start();