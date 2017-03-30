<?php
// @arquivo = /controller/ComponenteController.php
// MVC = controller
// objeto = Componente

require_once('../dao/ComponenteDAO.php');

class ComponenteController {

  public function register (Componente $componente, $flx_cod, $dcp_cod) {
    $componenteDAO = new ComponenteDAO();
    return $componenteDAO->register($componente);
  }

  public function update (Componente $componente) {
    $componenteDAO = new ComponenteDAO();
    return $componenteDAO->update($componente);
  }

  public function remove ($flx_cod, $dcp_cod) {
    $componenteDAO = new ComponenteDAO();
    return $componenteDAO->remove($prf_cod);
  }

  public function search ($flx_cod, $dcp_cod) {
    $componenteDAO = new ComponenteDAO();
    return $componenteDAO->search($flx_cod, $dcp_cod);
  }

  public function searchAll () {
    $componenteDAO = new ComponenteDAO();
    return $componenteDAO->searchAll();
  }

}

?>
