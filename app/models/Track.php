<?php

namespace app\models;

use vendor\core\Model;

/**
 * Class Track
 * Use to get information about the track
 * @package app\models
 */
class Track extends Model
{
  private $trackId;
  private $wrench;

  public function setId(int $trackId)
  {
    try {
      $this->trackId = $trackId;
    } catch (\Exception $e) {
      echo 'Incorrect assignment of a value to a variable' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }

  public function setWrench(string $wrench)
  {
    try {
      $this->wrench = $wrench;
    } catch (\Exception $e) {
      echo 'Incorrect assignment of a value to a variable' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }

  public function getTrackInformationById(): array
  {
    if (isset($this->trackId) && $this->trackId != '') {
      try {
        return $this->getRow("SELECT * FROM racetracks WHERE id = ?", [$this->trackId]);
      } catch (\Exception $e) {
        echo 'Error while retrieving information about track by id' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
      }
    }
    return [];
  }

  public function getFileByWrench()
  {
    try {
      if ($this->wrench) {
        return strval($this->getRow("SELECT file FROM racetracks WHERE wrench = ?", [$this->wrench])["file"]);
      }
    } catch (\Exception $e) {
      echo 'Error while retrieving file by wrench' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }

  public function getInformationByWrench()
  {
    try {
      if ($this->wrench) {
        return $this->getRow("SELECT * FROM racetracks WHERE wrench = ?", [$this->wrench]);
      }
    } catch (\Exception $e) {
      echo 'Error while retrieving all by wrench' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }
}