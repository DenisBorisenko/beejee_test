<?php

namespace Core;

use ErrorException;

use App\Controllers\Task;

class Kernel {

    private $defaultControllerName = 'Spa';
    private $defaultActionName = "index";

    private $controllerName;
    private $actionName;
    private $params;


    public function launch() {

        [$this->controllerName, $this->actionName, $this->params] = App::$router->resolve();
        echo $this->processAction();
    }

    public function processAction() {
        try {
            $this->requireController();
            $controller = $this->createControllerInstance();
            return $this->runControllerAction($controller);

        } catch (\Exception $exception) {
            echo $exception;
        }
    }

    private function requireController() {
        $controllerFileName = $this->retrieveControllerPath();
        if (!file_exists($controllerFileName)) {
            throw new ErrorException();
        }

        require_once $controllerFileName;
    }

    private function retrieveControllerPath() {
        if (empty($this->controllerName)) {
            $this->controllerName = $this->defaultControllerName;
        } else {
            $this->controllerName = ucfirst($this->controllerName);
        }

        return config('APP_PATH') . config('DS') . 'Controllers' . config('DS') . $this->controllerName . '.php';
    }

    private function createControllerInstance() {
        $controllerClassPath = 'App' . config('NSS') . 'Controllers' . config('NSS') . $this->controllerName;
        return new $controllerClassPath;
    }

    private function runControllerAction($controller) {
        if (empty($this->actionName)) {
            $this->actionName = $this->defaultActionName;
        }

        if (!method_exists($controller, $this->actionName)) {
            throw new ErrorException();
        }

        return $controller->{$this->actionName}($this->params);
    }

}
