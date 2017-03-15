<?php

  class Componente {
    private $flx_cod;
    private $dcp_cod;
    private $dcp_sem;
    private $dcp_hor;

    public function getFlx_cod() {
      return $this->flx_cod;
    }

    public function setFlx_cod ($flx_cod) {
      $this->flx_cod = $flx_cod;
    }

    public function getDcp_cod() {
      return $this->dcp_cod;
    }

    public function setDcp_cod ($dcp_cod) {
      $this->dcp_cod = $dcp_cod;
    }

    public function getDcp_sem() {
      return $this->dcp_sem;
    }

    public function setDcp_sem ($dcp_sem) {
      $this->dcp_sem = $dcp_sem;
    }

    public function getDcp_hor() {
      return $this->dcp_hor;
    }

    public function setDcp_hor ($dcp_hor) {
      $this->dcp_hor = $dcp_hor;
    }

    public function setAll($flx, $dcp, $sem, $hor) {
      $this->flx_cod = $flx;
      $this->dcp_cod = $dcp;
      $this->dcp_sem = $sem;
      $this->dcp_hor = $hor;
    }
  }
?>
