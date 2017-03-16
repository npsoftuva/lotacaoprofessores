<?php

  class Sala {
    private $sla_cod;
    private $sla_nom;
    private $sla_cap;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $nom, $cap) {
      $this->sla_cod = $cod;
      $this->sla_nom = $nom;
      $this->sla_cap = $cap;
    }
  }
?>
