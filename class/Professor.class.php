<?php

  include_once("BD.class.php");

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
      $this->pfr_cod = $cod;
      $this->prf_nom = $nom;
      $this->prf_cpf = $cpf;
      $this->prf_eml = $eml;
      $this->prf_sit = $sit;
    }

    public function searchAll() {
      $search = Conexao::getInstance()->prepare("SELECT * FROM tab_prf");

      if ($search->execute()) {
        while ($prf = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Professor();
          $aux->setAll($prf["prf_cod"], $prf["prf_nom"], $prf["prf_cpf"], $prf["prf_eml"], $prf["prf_sit"]);
          $prfs[] = $aux;
        }
        return $prfs;
      } else
        return false;
    }
  }
?>
