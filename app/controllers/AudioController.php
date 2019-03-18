<?php

namespace app\controllers;

use vendor\core\Controller;

class AudioController extends Controller
{
  public function idAction($id)
  {
    echo $id;
    $this->view->render('id/index');
    return true;
  }
}