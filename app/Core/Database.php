<?php

namespace Core;

use PDO;

class Database extends PDO {

    public function __construct() {

        parent::__construct(
            'mysql:host=' . config('DB_HOST') . ';dbname=' . config('DB_NAME') . ';charset=utf8',
            config('DB_USER'),
            config('DB_PASSWORD')
        );

    }
}
