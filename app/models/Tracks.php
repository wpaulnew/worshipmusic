<?php

namespace app\models;

use vendor\core\Model;

/**
 * Class Tracks
 * Use to get the tracks, filters and more
 * @package app\models
 */
class Tracks extends Model
{
  public function getInitialTracks(): array
  {
    try {
      return $this->getRows("SELECT * FROM racetracks LIMIT 10");
    } catch (\Exception $e) {
      echo 'Error getting the initial list of tracks' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }

  public function getMoreTracks(int $count):array {
    try {
      $finalcount = $count + 10;
      return $this->getRows("SELECT * FROM racetracks LIMIT $finalcount"); // ORDER BY RAND()
    } catch (\Exception $e) {
      echo 'The error in the return array of tracks to load' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }
}