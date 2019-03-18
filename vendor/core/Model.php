<?php

namespace vendor\core;

class Model
{
  public $pdo;

  function __construct()
  {
    $this->pdo = Db::instance();
  }

  protected function execute($sql)
  {
    $stmt = $this->pdo->pdo->prepare($sql);
    $stmt->execute();
  }

  protected function prepare($sql, $values)
  {
    try {
      $sth = $this->pdo->pdo->prepare($sql);
      $sth->execute($values);
      return $sth;
    } catch (\PDOException $e) {
      die($e->getMessage());
    }
  }

  // get row
  protected function getRow($query, $params = [])
  {
    try {
      $stmt = $this->pdo->pdo->prepare($query);
      $stmt->execute($params);
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      throw new \Exception($e->getMessage());
    }
  }

  // get rows
  protected function getRows($query, $params = [])
  {
    try {
      $stmt = $this->pdo->pdo->prepare($query);
      $stmt->execute($params);
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      throw new \Exception($e->getMessage());
    }
  }

  // insert row
  protected function insertRow($query, $params = [])
  {
    try {
      $stmt = $this->pdo->pdo->prepare($query);
      $stmt->execute($params);
      return TRUE;
    } catch (\PDOException $e) {
      throw new \Exception($e->getMessage());
    }
  }

  // insert row
  protected function insertEmptyRow($query)
  {
    try {
      $stmt = $this->pdo->pdo->prepare($query);
      $stmt->execute();
      return true;
    } catch (\PDOException $e) {
      throw new \Exception($e->getMessage());
    }
  }

  // update row
  protected function updateRow($query, $params = [])
  {
    $this->insertRow($query, $params);
  }

  // delete row
  protected function deleteRow($query, $params = [])
  {
    $this->insertRow($query, $params);
  }

  // find row
  protected function findRow($query, $params = [])
  {
    try {
      $stmt = $this->pdo->pdo->prepare($query);
      $stmt->execute($params);
      return $stmt->rowCount();
    } catch (\PDOException $e) {
      throw new \Exception($e->getMessage());
    }
  }

}