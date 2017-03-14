<?php

  include_once("BD.class.php");

  class Lotacao {
    private $lot_cod;
    private $ofr_cod;
    private $prf_cod;
    private $sla_cod;
    private $lot_dia;
    private $lot_hor;
    private $lot_int;
    private $lot_qtd;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $ofr, $prf, $sla, $dia, $hor, $int, $qtd) {
      $this->lot_cod = $cod;
      $this->ofr_cod = $ofr;
      $this->prf_cod = $prf;
      $this->sla_cod = $sla;
      $this->lot_dia = $dia;
      $this->lot_hor = $hor;
      $this->lot_int = $int;
      $this->lot_qtd = $qtd;
    }
  }
?>
