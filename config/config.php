<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:dbhost=localhost;dbname=snsdb');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', '********');

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once(__DIR__.'/../lib/functions.php');
require_once(__DIR__.'/autoload.php');

session_start();
