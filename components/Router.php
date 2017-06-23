<?php


class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    //возвращает урл
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        //Получить строку запроса
        $uri = $this->getURI();
        //Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {

            //Сравниваем $urlPattern и $url
            if (preg_match("~$uriPattern~", $uri)) {

                echo "Где ищем (запрос, который набрал пользователь): $uri<br>";
                echo "Что ищем (совпадение из правила): $uriPattern<br>";
                echo "Кто обрабатывает: $path<br>";
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                echo "нужно сформировать: $internalRoute";
                //Определяем какой контроллер и action обрабатывает запрос
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters=$segments;


                //Подключить файл класса контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                //Создать объект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject,$actionName),$parameters);
                if ($result != null) {
                    break;
                }
            }
        }
    }
}