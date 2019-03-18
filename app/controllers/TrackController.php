<?php

namespace app\controllers;

use app\models\Track;
use app\models\Tracks;
use vendor\core\Controller;
use vendor\library\Post;

class TrackController extends Controller
{
  public function indexAction()
  {
    if ($this->isAJAX()) {
      $tracks = new Tracks();
      $tracks = $tracks->getInitialTracks();
      exit($this->toJSON($tracks));
    }
    return true;
  }

  public function informationAction()
  {
    if ($this->isAJAX()) {
      $track = new Track();
      $track->setId(Post::get("trackId"));
      exit($this->toJSON($track->getTrackInformationById()));
    }

    $this->view->render('home/index');
    return true;
  }
}
