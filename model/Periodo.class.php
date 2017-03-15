<?php

  class Periodo {
    private $prd_cod;
    private $prd_ini;
    private $prd_fim;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $ini, $fim) {
      $this->prd_cod = $cod;
      $this->prd_ini = $ini;
      $this->prd_fim = $fim;
    }
  }
?>
