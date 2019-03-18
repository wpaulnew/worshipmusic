<?php

namespace app\controllers;

use app\models\Downloader;
use app\models\File;
use app\models\T;
use vendor\core\Controller;
use vendor\library\Post;

class DownloadController extends Controller
{

  public function indexAction()
  {
    if ($this->isAJAX()) {

      // Получаем id
      $id = Post::get("id");

      // Создаем обьект трека самого, вытягиваем из хранилища
      $t = new T();
      $t->setid($id);
      $t->getallabouttrack();

      // Проверяем сущействует ли файл в папке
      $file = new File();
      $file->setName($t->getfile() . ".mp3");
      $have = $file->have(MEDIA);

      // Файл существует мы его просто отдаем
      if ($have) {
        exit($this->toJSON(
          [
            "file" => $t->getfile(),
          ]
        ));
      }

      // Файл не существует, мы его скачиваем, а потом отдаем
      if (!$have) {

        // Создаем случайное имя из времени
        $time = substr(md5(time()), 16);

        $downloader = new Downloader();
        $downloader->setid($id);
        $ref = "http://fonki.pro/plugin/sounds/uploads/" . $t->getref() . ".mp3";
        $downloader->setref($ref);
        $downloader->setfilename($time);

        // Загружаем файл
        $downloader->download();

        $title = $t->gettitle();
        $executor = $t->getexecutor();

        //Переименовываем скачаный файл
        $downloader->setfilename($time);
        $downloader->settitle($title);
        $downloader->setexecutor($executor);
        $downloader->rename();

        // Сохраняем имя на файл в хранилище
        $downloader->setid($t->getid());
        $downloader->setfilename($time);
        $downloader->save();

        exit($this->toJSON(
          [
            "file" => $time . ".mp3"
          ]
        ));
      }

      $this->redirect(HOST);
      return true;
    }
  }

}
