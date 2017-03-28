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
		

    public function searchAll() {
      $search = Conexao::getInstance()->prepare("SELECT * FROM tab_flx");

      if ($search->execute()) {
        while ($flx = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Fluxo();
          $aux->setAll($flx["flx_cod"], $flx["flx_trn"], $flx["flx_sem"]);
          $flxs[] = $aux;
        }
        return $flxs;
      } else
        return false;
    }
  }
?>
