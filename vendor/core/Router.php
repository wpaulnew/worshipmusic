<?php

namespace vendor\core;

class Router
{

  private $routes;
  public $view = false;

  public function __construct($routes)
  {
    if (is_array($routes)) {
      $this->routes = $routes;
    }
  }

  // Метод получает URI. Несколько вариантов представлены для надёжности.
  public function getLink()
  {
    if (!empty($_SERVER['REQUEST_URI'])) {
      return trim($_SERVER['REQUEST_URI'], '/');
    }
  }

  public function match($link)
  {
    foreach ($this->routes as $pattern => $route) {
      // Если правило совпало.
      if (preg_match("~$pattern~", $link)) {
        // Получаем внутренний путь из внешнего согласно правилу.
        // echo $pattern;
        $internalRoute = preg_replace("~$pattern~", $route, $link); // В случае ошибки заменить #~ на ~
        // Разбиваем внутренний путь на сегменты.
//                echo $pattern . " " . $route;
        return explode('/', $internalRoute);
      }

    }
  }

  public function map()
  {
//    echo "<pre>";
    $routes = $this->routes;
    $map = [];
    foreach ($routes as $index => $value) {
      $map[trim($index, "^$")] = $value;
    }
    foreach ($map as $route => $action) {
      echo "<b>Route </b><b>{ </b>$route<b> }</b> > <b>Action</b> <b>{ </b>$action<b> }</b><br>";
    }
    echo "<br>";
  }

  public function run()
  {
    // Получаем URL.
    $link = $this->getLink();

    // Возвращаем масив разделеный
    $segments = $this->match($link);


    if ($segments) {

      if ($segments[0] == "admin") {
        array_shift($segments);
        $controller = "app\controllers\admin\\" . ucfirst(array_shift($segments)) . 'Controller';
        $obj = new $controller();
        $action = lcfirst(array_shift($segments)) . "Action";
        $parameters = $segments;
        call_user_func_array(array($obj, $action), $parameters);
        exit();
      } else {
        // Получаем название контролера
        $controller = "app\controllers\\" . ucfirst(array_shift($segments)) . 'Controller';

        if ($this->view)
          echo "<b>Controller</b> (<em>$controller</em>)<br>";

        // Проверям существование класса
        if (class_exists($controller)) {
//                echo $controller . "     ";
          // Создаем обьект контролера
          $obj = new $controller();
          $action = lcfirst(array_shift($segments)) . "Action";

          if ($this->view)
            echo "<b>Action</b> (<em>$action</em>)<br>";

          if (method_exists($obj, $action)) {
            // Записываем параметры
            $parameters = $segments;
            // проверяем существуют ли параметры
            if (isset($parameters)) {

              if ($this->view)
                if (!empty($parameters[0])) {
                  echo "<b>Parameters</b> (<em>$parameters[0]</em>)<br>";
                }


              // Создаем обьект контролера и передаем экшену параметры
              call_user_func_array(array($obj, $action), $parameters);
            } else {
              // Создаем обьект контролера без передачи параметров экшену
              call_user_func(array($obj, $action));
            }
          } else {
            echo "Action <b>" . $action . "</b> not found in obj <b>" . $controller . "</b>";
          }
        } else {
          echo "Controller " . $controller . " not found";
        }
      }

    } else {
      http_response_code(404);
      include("404.php");
    }
  }
}
