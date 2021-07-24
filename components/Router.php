<?php

class Router
{

	private $routes;

	/*
	*Подключает файл с маршрутами и обновляет переменную routes
	*/
	public function __construct()
	{
		//подключить файл с маршрутами
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	/*
	*Возвращает строку запроса
	*/
	private function getURI()
	{	
		//Получить строку запроса
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	/*
	*Подключает нужный контроллер и метод
	*/
	public function run()
	{
		//Получить строку запроса
		$uri = $this->getURI();
		//Проверить наличие такого запроса в routes.php
		foreach ($this->routes as $uriPattern => $path) {
			if(preg_match("~$uriPattern~", $uri)){

				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				
			
				$segments = explode('/', $internalRoute);

				//определить какой контроллер
				$controllerName = ucfirst(array_shift($segments).'Controller');

				//определить какой экшн
				$actionName = 'action'.ucfirst(array_shift($segments));
				
				//определить параметры запроса
				$parameters = $segments;

				//Подключить файл класса контроллера
				$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

				if(file_exists($controllerFile)){
					include_once($controllerFile);
				}
				//Создать обьект, вызвать метод (экшн)
				$controllerObject = new $controllerName;

				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);

				if ($result != null) {
					break;
				}
			}
		}
	}
}