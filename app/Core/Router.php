<?php

namespace Core;

class Router {

    const URL_QUERY_PARAM_POINTER = '?';

    private $route;
    private $parsedRoute;

    public function __construct() {
        $this->route = $_SERVER['REQUEST_URI'];
        $this->parsedRoute = $this->route;
    }

    public function resolve() {
        $this->removeQueryParams();
        $this->splitRouteOnParts();
        return $this->fillSplitsRouteParts();
    }

    protected function removeQueryParams() {
        $positionOfQueryParams = strpos($this->parsedRoute, self::URL_QUERY_PARAM_POINTER);

        if ($positionOfQueryParams) {
            $this->parsedRoute = substr($this->parsedRoute, 0, $positionOfQueryParams);
        }
    }

    protected function splitRouteOnParts() {
        $this->parsedRoute = is_null($this->parsedRoute) ? $this->route : $this->parsedRoute;
        $this->parsedRoute = explode('/', $this->parsedRoute);
    }

    protected function fillSplitsRouteParts() {
        array_shift($this->parsedRoute);

        return [
            array_shift($this->parsedRoute),
            array_shift($this->parsedRoute),
            $this->parsedRoute,
        ];
    }
}
