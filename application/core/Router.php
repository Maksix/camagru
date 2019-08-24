<?php

namespace application\core;

class Router
{

    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $url = trim(stristr($url, '/'), '/');

        if (preg_match('/^gallery\/[a-z0-9]{3,15}$/i', $url)) {
            $login = trim(substr($url, strrpos($url, '/')), '/');
            $this->params = [
                'controller' => 'gallery',
                'action' => 'gallery',
                'login' => $login,
            ];
            return true;
        }

        if (preg_match('/^account\/confirm\/[A-z0-9]{64}/', $url)) {
            $token = trim(substr($url, strrpos($url, '/')), '/');
            $this->params = [
                'controller' => 'account',
                'action' => 'confirm',
                'token' => $token,
            ];
            return true;
        }

        if (preg_match('/^account\/reset\/[A-z0-9]{64}/', $url)) {
            $token = trim(substr($url, strrpos($url, '/')), '/');
            $this->params = [
                'controller' => 'account',
                'action' => 'reset',
                'token' => $token,
            ];
            return true;
        }

        if (preg_match('/[0-9]{1,100}/', $url)) {
            $page = trim(substr($url, strrpos($url, '/')), '/');
            $this->params = [
                'controller' => 'main',
                'action' => 'index',
                'page' => $page,
            ];
            return true;
        }

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(403);
        }
    }
}
