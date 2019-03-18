<?php

namespace vendor\library;

class Session
{
  /**
   * Должны быть методы:
   * 1. Добавить чтото в сесию
   */
//    public static $key;
//    public static $values;

  /**
   * Сохраняет данные по ключю
   * @param $key
   * @param $values
   * @return mixed
   */
  public static function create($index, $values)
  {
    return $_SESSION[$index] = $values;
  }

  /**
   * Получает данные по ключю
   */
  public static function get($index)
  {
    if (isset($_SESSION[$index])) {
      return $_SESSION[$index];
    }
    return false;
  }

  /**
   * Существует ли значение с таим ключем
   * @param $key
   * @return bool
   */
  public static function is($index)
  {
    return isset($_SESSION[$index]) ? true : false;
  }

  /**
   * Удаляет по ключю
   */
  public static function remove($key)
  {
    unset($_SESSION[$key]);
  }

  /**
   * Обновись значение по ключю
   */
  public static function update($key, $values)
  {
    return $_SESSION[$key] = $values;
  }
}