<?php

namespace Core;

class App {

    public static $router;

    public static $database;

    public static $kernel;

    public static function init() {
        static::bootstrap();
    }

    public static function bootstrap() {
        static::$router = new Router();
        static::$database = new Database();
        static::$kernel = new Kernel();
    }
}
