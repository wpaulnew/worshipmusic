<?php

session_start();

// Подключаем загрузку классов
require("../vendor/autoload.php");

// Подключаем настройки приложения
require("../vendor/settings/reporting.php");
require("../vendor/settings/defines.php");

$routes = require_once('../vendor/settings/routes.php');
$router = new \vendor\core\Router($routes);
$router->view = false;
//$router->map();

// Подключаем защиту
$security = new \vendor\library\Security();
if (!\vendor\library\Session::get("TOKEN")) {
  $security->generatetoken();
}

// Запускаем все
$router->run();


