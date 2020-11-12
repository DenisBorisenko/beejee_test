<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use App\Models\Task as TaskModel;

class Task extends Controller {

    public const TODO_PER_PAGE = 3;
    public const DEFAULT_SORT = 'id DESC';

    public function index() {
        $model = new TaskModel([
            'ORDER'  => $this->retrieveSortParams(),
            'LIMIT'  => self::TODO_PER_PAGE,
            'OFFSET' => isset($_GET['offset']) ? $_GET['offset'] : null,
        ]);

        return json_encode([
            'data'  => $model->getAllRows(),
            'total' => $model->selectTotalCountRows(),
        ]);
    }

    private function retrieveSortParams() {
        if (isset($_GET['sortColumn'])) {
            $sortColumn = $_GET['sortColumn'];
            $sortType = $_GET['sortType'];

            return "$sortColumn $sortType";
        } else {

            return self::DEFAULT_SORT;
        }
    }

    public function store() {
        $validationErrors = $this->validator->process([
            'userName'  => 'required',
            'userEmail' => 'required|email',
            'body'      => 'required',
        ]);

        if (count($validationErrors)) {
            http_response_code(422);
            return json_encode($validationErrors);
        }

        $model = new TaskModel();
        $model->user_name = $_POST['userName'];
        $model->user_email = $_POST['userEmail'];
        $model->body = $_POST['body'];
        $model->save();
        return $model;
    }

    public function update() {
        if (!User::isAuthorized()) {
            http_response_code(401);
        }

        $model = new TaskModel([
            'WHERE' => 'id = ' . $_POST['id'],
        ]);
        $model->fetchOne();

        if (isset($_POST['body'])) {
            $model->body = $_POST['body'];
            $model->is_changed = 1;
        }
        if (isset($_POST['is_completed'])) {
            $model->is_completed = (int) $_POST['is_completed'];
        }
        if (isset($_POST['user_name'])) {
            $model->user_name = $_POST['user_name'];
        }
        if (isset($_POST['user_email'])) {
            $model->user_email = $_POST['user_email'];
        }

        return $model->update();

    }

}