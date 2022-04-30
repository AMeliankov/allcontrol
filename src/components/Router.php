<?php

class Router {
    
    // массив с роутами
    private  $routes; 
    
    public function __construct() {

        // путь к роутам, массив routes.php
        $routesPath = ROOT.'/config/routes.php';

        // подключаем массив с роутами
        $this->routes = include($routesPath);     
    }
    
    public function run() {
        
        // получаем строку запроса
        $uri = $this->getURI();
        
        // проверяем наличие запроса в routes.php
        foreach ($this->routes as $uriPattern => $path){

            // $path - хранится имя контроллера и action, если условие = 1
            
            // ищем совпадение со строкой запроса и массива с роутами
            if(preg_match("~$uriPattern~",  $uri)) {

                $internalRooute = preg_replace("~$uriPattern~", $path, $uri);
                
                // если есть совпадения, то определить какой контроллер и action обробатывают запрос
                
                $segments = explode('/', $internalRooute);
               
                $controllerName = array_shift($segments).'Controller';

                // имя контроллера
                $controllerName = ucfirst($controllerName); 
                
                // событие
                $actionName = 'action'.ucfirst(array_shift($segments)); 

                // параметры
                $parameters = $segments;
                 
                // подключение файла класса контроллера 
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)) {
                    include_once $controllerFile;
                }
        
                // создаем объект подключеннго класса, вызов метода (т.е. action)
                $controllerObject = new $controllerName;
                
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                        
                if($result != null) {
                    break;
                } else {
                    break;
                }
            }   
        }
    } 

    // получение строки запроса
    private function getURI(){ 
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        } 
    }
}

