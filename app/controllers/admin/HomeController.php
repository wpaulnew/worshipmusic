<?php

namespace app\controllers\admin;

use app\models\Tracks;
use vendor\core\Controller;

class HomeController extends Controller
{
  public function indexAction()
  {
    $this->view->render('panel/index');
    return true;
  }

  public function loginAction() {
    $this->view->layout = "panel";
    $this->view->render('panel/login');
    return true;
  }
}