<?php

  include_once 'Fluxo.class.php';
  include_once 'Disciplina.class.php';

  class Componente {
    private $flx_cod;
    private $dcp_cod;
    private $cmp_sem;
    private $cmp_hor;

    public function __set($atr, $value){
			$this->atr = $value;
		}
		
		public function __get($atr){
			return $this->$atr;
		}

    public function setAll($flx, $dcp, $sem, $hor) {
      $this->flx_cod = $flx;
      $this->dcp_cod = $dcp;
      $this->cmp_sem = $sem;
      $this->cmp_hor = $hor;
    }
  }
?>
