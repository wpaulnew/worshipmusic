<?php

namespace vendor\library;

class Security
{
  private $token;

  public function generatetoken()
  {
    Session::create("TOKEN", md5(uniqid("")));
  }

  public function gettoken()
  {
    return Session::get("TOKEN");
  }

  public function correct($token)
  {
    return Session::get("TOKEN") == $token ? true : false;
  }
}