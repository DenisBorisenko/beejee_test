<?php
session_start();

use Core\App;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require '../vendor/autoload.php';

App::init();
return App::$kernel->launch();
