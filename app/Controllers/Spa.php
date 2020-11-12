<?php

namespace App\Controllers;

use Core\Controller;

class Spa extends Controller {

    public function index() {
        $this->template->view('spa');
    }

}