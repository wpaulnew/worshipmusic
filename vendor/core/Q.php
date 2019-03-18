<?php

namespace vendor\core;

use vendor\core\Model;

/**
 * Class Find
 * An example of the class sequence
 * @package app\models
 */
class Q extends Model
{
  private $select;
  private $from;
  private $where;
  private $value;
  private $kind;

  public function getWhere()
  {
    return $this->where;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function kind($kind)
  {
    $this->kind = $kind;
    return $this;
  }

  public function select(array $property): Q
  {
    $this->select = '';
    foreach ($property as $p) {
      $this->select .= $p;
    }
    return $this;
  }

  public function from(string $property): Q
  {
    $this->from .= $property;
    return $this;
  }

  public function request(): array
  {
    if ($this->kind == "select") {
      if ($this->where) {
        return $this->getRow("SELECT $this->select FROM $this->from WHERE $this->where", $this->value);
      }
      return $this->getRow("SELECT $this->select FROM $this->from");
    }
  }
}