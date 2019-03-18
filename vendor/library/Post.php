<?php

namespace vendor\library;

class Post
{
  public static function verification($index)
  {
    if (isset($_POST[$index])) {
      return true;
    }
    return false;
  }

  public static function set($index, $value)
  {
    return $_POST[$index] = $value;
  }

  public static function get($index)
  {
    try {
      return $_POST[$index];
    } catch (\Exception $e) {
      echo "No index($index) in POST array" . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }
}