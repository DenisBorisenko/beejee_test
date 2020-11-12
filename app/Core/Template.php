<?php

namespace Core;

class Template {

    public function view($name) {
		$page = config('ROOT_PATH') . config('DS') . 'resources' . config('DS') . 'views' . config('DS') . $name . '.php';

		if (!file_exists($page)) {
		    return false;
		}

		include ($page);
	}
	
}