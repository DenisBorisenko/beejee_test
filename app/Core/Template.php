<?php

namespace Core;

class Template {

    public function view($name) {
		$page = config('ROOT_PATH') . config('DS') . 'app' . config('DS') . 'Views' . config('DS') . $name . '.php';

		if (!file_exists($page)) {
		    return false;
		}

		include ($page);
	}
	
}