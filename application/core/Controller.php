<?php

namespace application\core;

abstract class Controller
{

	public $route;
	public $view;
	public $model;
	public $acl;

	public function __construct($route)
	{
		$this->route = $route;
		if (!$this->checkAcl()) {
			View::errorCode(403);
		}
		$this->view = new View($route);
		$this->model = $this->LoadModel($route['controller']);
	}

	public function loadModel($name)
	{
		$path = 'application\models\\' . ucfirst($name);
		if (class_exists($path)) {
			return new $path;
		}
	}

	public function checkAcl()
	{
		$this->acl = require 'application/acl/' . $this->route['controller'] . '.php';
		if ($this->isAcl('guest') && !isset($_SESSION['authorized']['id'])) {
		    return true;
		} elseif (isset($_SESSION['authorized']['id']) && $this->isAcl('authorized')) {
			return true;
		} elseif (isset($_SESSION['admin']) && $this->isAcl('admin')) {
			return true;
		}
		return false;
	}

	public function isAcl($key)
	{
		return in_array($this->route['action'], $this->acl[$key]);
	}
}