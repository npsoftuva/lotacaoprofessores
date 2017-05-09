<?php
// @arquivo = /controller/LotacaoController.php
// MVC = controller
// objeto = Lotacao

require_once('../dao/LotacaoDAO.php');

class LotacaoController {

  public function register (Lotacao $lotacao) {
    $lotacaoDAO = new LotacaoDAO();
    return $lotacaoDAO->register($lotacao);
  }

  public function searchAll() {
    $lotacaoDAO = new LotacaoDAO();
    return $lotacaoDAO->searchAll();
  }

  public function remove ($ofr_cod){
    $lotacaoDAO = new LotacaoDAO();
    return $lotacaoDAO->remove($ofr_cod);
  }

}

?>