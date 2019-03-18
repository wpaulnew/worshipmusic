<?php

namespace app\models;

use vendor\core\Model;

/**
 * Class T
 * Use to get information about the track
 * @package app\models
 */
class T extends Model
{
  protected $id;
  protected $loaded;
  protected $title;
  protected $executor;
  protected $icon;
  protected $file;
  protected $ref;
  protected $wrench;
  protected $words;
  protected $rating;

  /**
   * @param mixed $id
   */
  public function setid($id): void
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getid()
  {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function gettitle()
  {
    return $this->title;
  }

  /**
   * @return mixed
   */
  public function getexecutor()
  {
    return $this->executor;
  }

  /**
   * @return mixed
   */
  public function getfile()
  {
    return $this->file;
  }

  /**
   * @return mixed
   */
  public function getref()
  {
    return $this->ref;
  }

  public function getallabouttrack(): bool
  {
    try {
      $track = $this->getRow("SELECT * FROM racetracks WHERE id = ?", [$this->id]);

      $this->id = $track["id"];
      $this->loaded = $track["loaded"];
      $this->title = $track["title"];
      $this->executor = $track["executor"];
      $this->icon = $track["icon"];
      $this->file = $track["file"];
      $this->ref = $track["ref"];
      $this->wrench = $track["wrench"];
      $this->words = $track["words"];
      $this->rating = $track["rating"];

      return true;

    } catch (\Exception $e) {
      echo 'Error while retrieving information about track by id' . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n";
    }
  }
  /**
   * Что должен делать?
   */

}