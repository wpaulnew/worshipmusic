<?php

namespace vendor\core;

use vendor\core\View;

abstract class Controller
{
  protected $view;

  function __construct()
  {
    $this->view = new View();
  }

  public function isAJAX()
  {
    return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";
  }

  public function redirect($url, $permanent = false)
  {
    if (headers_sent() === false) {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
  }

  public function toJSON(array $array)
  {
    return json_encode($array);
  }
}