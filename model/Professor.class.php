<?php

  class Professor {
    private $prf_cod;
    private $prf_nom;
    private $prf_cpf;
    private $prf_eml;
    private $prf_sit;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $nom, $cpf, $eml, $sit) {
      $this->prf_cod = $cod;
      $this->prf_nom = $nom;
      $this->prf_cpf = $cpf;
      $this->prf_eml = $eml;
      $this->prf_sit = $sit;
    }

  }
?>
