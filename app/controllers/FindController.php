<?php

namespace app\controllers;

use app\models\Find;

use vendor\core\Controller;
use vendor\library\Post;

class FindController extends Controller
{
  public function indexAction()
  {
    if ($this->isAJAX()) {
      $find = new Find();
      $find->setFindString(Post::get("findString"));
      $founded = $find->find();

      // Возможно все стоит записать одной строкой
      if ($founded) {
        exit($this->toJSON($founded));
      }
      exit($this->toJSON(["condition"=>false]));
    }
  }

  public function quantityAction()
  {
    return true;
  }
}