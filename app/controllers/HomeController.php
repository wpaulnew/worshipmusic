<?php

namespace app\controllers;

use app\models\Tracks;
use vendor\core\Controller;

class HomeController extends Controller
{
  public function indexAction()
  {
    $tracks = new Tracks();
    $tracks = $tracks->getInitialTracks();
    $this->view->render('home/index', ["tracks" => $tracks]);
    return true;
  }
}