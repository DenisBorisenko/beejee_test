<?php

namespace App\Models;

use Core\Model;

class User extends Model {

    public $id;
    public $login;
    public $password;

    public function fieldsTable() {
        return [
            'id'       => 'Id',
            'login'    => 'Login',
            'password' => 'password',
        ];
    }

    static function isAuthorized() {
        return isset($_SESSION['user']);
    }

}