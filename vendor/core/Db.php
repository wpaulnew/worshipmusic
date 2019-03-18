<?php

namespace vendor\core;

class Db
{
  public $pdo;
  protected static $instance;

  protected function __construct()
  {
    $conn = [
      'dsn' => 'mysql:host=127.0.0.1;dbname=localhost;charset=utf8',
      'login' => 'root',
      'password' => '',
    ];
    $this->pdo = new \PDO($conn["dsn"], $conn["login"], $conn["password"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
  }

  public static function instance()
  {
    if (self::$instance === null) {
      self::$instance = new self;
    }
    return self::$instance;
  }
}