<?php

  class Calendario {
    private $cld_dta;
    private $cld_dia;
    private $cld_evt;
    private $cld_tpo;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($dta, $dia, $evt, $tpo) {
      $this->cld_dta = $dta;
      $this->cld_dia = $dia;
      $this->cld_evt = $evt;
      $this->cld_tpo = $tpo;
    }
  }
?>
