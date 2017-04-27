<?php
// @arquivo = /controller/LotacaoController.php
// MVC = controller
// objeto = Lotacao

require_once('../dao/LotacaoDAO.php');

class LotacaoController {

  public function searchAll() {
    $lotacaoDAO = new LotacaoDAO();
    return $lotacaoDAO->searchAll();
  }

}

?>