<?php

  class Fluxo {
    private $flx_cod;
    private $flx_trn;
		private $flx_sem;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $trn, $sem) {
      $this->flx_cod = $cod;
      $this->flx_trn = $trn;
			$this->flx_sem = $sem;
    }
  }
?>
