<?php

namespace App\Models;

use Core\Model;

class Task extends Model {

    public $id;
    public $body;
    public $user_name;
    public $user_email;
    public $is_changed;
    public $is_completed;

    public function fieldsTable() {
        return [
            'id'           => 'Id',
            'body'         => 'Body',
            'user_name'    => 'User name',
            'user_email'   => 'User email',
            'is_changed'   => 'Is changed',
            'is_completed' => 'Is completed',
        ];
    }


}