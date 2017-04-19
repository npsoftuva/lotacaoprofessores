<?php

  class Usuario {
    private $usu_cod;
    private $usu_log;
    private $usu_sen;
    private $usu_tpo;

    public function __set($atr, $value) {
      $this->$atr = $value;
    }

    public function __get($atr) {
      return $this->$atr;
    }

    public function setAll($cod, $log, $sen, $tpo) {
      $this->usu_cod = $cod;
      $this->usu_log = $log;
      $this->usu_sen = $sen;
      $this->usu_tpo = $tpo;
    }
  }
?>
