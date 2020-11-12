<?php
session_start();

use Core\App;

require '../vendor/autoload.php';

App::init();
return App::$kernel->launch();
