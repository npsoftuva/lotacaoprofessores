<?php

  include_once("BD.class.php");

  class Disciplina {
    private $dcp_cod;
    private $dcp_nom;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $nom) {
      $this->dcp_cod = $cod;
      $this->dcp_nom = $nom;
    }

    public function searchAll() {
      $search = Conexao::getInstance()->prepare("SELECT * FROM tab_dcp");

      if ($search->execute()) {
        while ($dcp = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Disciplina();
          $aux->setAll($dcp["dcp_cod"], $dcp["dcp_nom"]);
          $dcps[] = $aux;
        }
        return $dcps;
      } else
        return false;
    }
  }
?>
