<?php

namespace Core;

use App\Services\ValidationService;

abstract class Controller {

    protected $template;
    protected $layouts;
    protected $validator;

    public function __construct() {
        $this->template = new Template($this->layouts, get_class($this));
        $this->validator = new ValidationService();
    }

    abstract function index();

}
