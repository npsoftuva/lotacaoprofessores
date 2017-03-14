<?php

  include_once("BD.class.php");

  class Oferta {
    private $ofr_cod;
    private $prd_cod;
    private $flx_cod;
    private $dcp_cod;
    private $ofr_trm;
    private $ofr_vag;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $prd, $flx, $dcp, $trm, $vag) {
      $this->ofr_cod = $cod;
      $this->prd_cod = $prd;
      $this->flx_cod = $flx;
      $this->dcp_cod = $dcp;
      $this->ofr_trm = $trm;
      $this->ofr_vag = $vag;
    }
  }
?>
