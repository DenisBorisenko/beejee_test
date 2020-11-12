<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;

class Auth extends Controller {

    public function index() {}

    public function login() {
        $validationErrors = $this->validator->process([
            'login'  => 'required',
            'password' => 'required',
        ]);

        if (count($validationErrors)) {
            http_response_code(422);
            return json_encode($validationErrors);
        }
        $login = $_POST['login'];
        $model = new User([
            'WHERE' => "login = '$login'"
        ]);
        $user = $model->getOneRow();

        if ($user && password_verify($_POST['password'], $user->password)) {
            $_SESSION['user'] = $model->fetchOne();
            return json_encode($model);
        }

        http_response_code(422);
        return json_encode(['password' => 'Неверные данные']);
    }

    public function logout() {
        session_destroy();
        http_response_code(401);
    }

    public function user() {
        return json_encode(User::isAuthorized());
    }

}