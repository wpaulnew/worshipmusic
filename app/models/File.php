<?php

namespace app\models;

use vendor\core\Model;

/**
 * Class Find
 * Use to search for songs
 * @package app\models
 */
class File extends Model
{
  private $name;

  public function setName(string $name)
  {
    $this->name = $name;
  }

  /**
   * Check if there is a file in the folder
   * @param string $folder
   * @return bool
   */
  public function have(string $folder): bool
  {
    try {
      return file_exists($folder . "/" . $this->name);
    } catch (\Exception $e) {
      echo 'File not found in folder' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }
}