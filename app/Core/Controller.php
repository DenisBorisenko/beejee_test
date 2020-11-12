<?php

namespace Core;

use App\Services\ValidationService;

abstract class Controller {

    protected $template;
    protected $validator;

    public function __construct() {
        $this->template = new Template();
        $this->validator = new ValidationService();
    }

    abstract function index();

}
