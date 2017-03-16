<?php

  class Disciplina {
    private $dcp_cod;
    private $dcp_nom;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $nom) {
      $this->dcp_cod = $cod;
      $this->dcp_nom = $nom;
    }

  }
?>
