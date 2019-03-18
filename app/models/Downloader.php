<?php

namespace app\models;

require(LIBS . "/getid3.php");
require(LIBS . "/write.php");

use vendor\core\Model;

class Downloader extends Model
{
  private $id;

  // Сыылка на оригинал песни
  private $ref;

  private $filename;
  private $directory;

  // Поля для файла
  private $title;
  private $executor;
  private $album = "worshipmusic.ru";

  public function setid($id)
  {
    $this->id = $id;
  }

  public function setref($ref)
  {
    $this->ref = $ref;
  }

  public function setfilename($filename)
  {
    $this->filename = $filename;
  }

  public function settitle($title)
  {
    $this->title = $title;
  }

  public function setexecutor($executor)
  {
    $this->executor = $executor;
  }

  public function setalbum($album)
  {
    $this->album = $album;
  }

  /**
   * @return mixed
   */
  public function getref()
  {
    return $this->ref;
  }

  public function rename()
  {
    $TaggingFormat = 'UTF-8';
    $getID3 = new \getID3();
    $getID3->setOption(array('encoding' => $TaggingFormat));

    // Initialize getID3 tag-writing module
    $tagwriter = new \getid3_writetags();
    $tagwriter->filename = MEDIA . '/' . $this->filename . ".mp3";
    $tagwriter->tagformats = array('id3v1', 'id3v2.3');

    // set various options (optional)
    $tagwriter->overwrite_tags = true;
    $tagwriter->tag_encoding = $TaggingFormat;
    $tagwriter->remove_other_tags = true;

    // populate data array
    $TagData['title'][] = $this->title;
    $TagData['artist'][] = $this->executor;
    $TagData['album'][] = $this->album;
    $tagwriter->tag_data = $TagData;

    // write tags
    if ($tagwriter->WriteTags()) {
      if (!empty($tagwriter->warnings)) {
        echo 'There were some warnings:<br>' . implode('<br><br>', $tagwriter->warnings);
      }
    } else {
      echo 'Failed to write tags!<br>' . implode('<br><br>', $tagwriter->errors);
    }
    return true;
  }

  // Сохраняем данные в таблице о том что файл переименнован, и записываем его название также
  public function save()
  {
    $this->updateRow("UPDATE racetracks SET loaded = 1, file = ? WHERE id = ?", [$this->filename, $this->id]);
  }

  // Скачивает файл с удаленого сервера на мой
  public function download()
  {
    $filename = pathinfo($this->ref, PATHINFO_FILENAME);
    $ext = pathinfo($this->ref, PATHINFO_EXTENSION);
    $dest = MEDIA . "/" . $this->filename . '.' . $ext;
    return copy($this->ref, $dest);
  }
}