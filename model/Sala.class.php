<?php

  include_once("BD.class.php");

  class Sala {
    private $sla_cod;
    private $sla_nom;
    private $sla_cap;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $nom, $cap) {
      $this->sla_cod = $cod;
      $this->sla_nom = $nom;
      $this->sla_cap = $cap;
    }

    public function searchAll() {
      $search = Conexao::getInstance()->prepare("SELECT * FROM tab_sla");

      if ($search->execute()) {
        while ($sla = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Sala();
          $aux->setAll($sla["sla_cod"], $sla["sla_nom"], $sla["sla_cap"]);
          $slas[] = $aux;
        }
        return $slas;
      } else
        return false;
    }
  }
?>
