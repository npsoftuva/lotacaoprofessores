<?php
// @arquivo = /controller/OfertaController.php
// MVC = controller
// objeto = Oferta

require_once('../dao/OfertaDAO.php');

class OfertaController {

  public function register (Oferta $oferta) {
    $ofertaDAO = new ofertaDAO();
    return $ofertaDAO->register($oferta);
  }

  public function update (Oferta $oferta) {
    $ofertaDAO = new OfertaDAO();
    return $ofertaDAO->update($oferta);
  }

  public function remove ($ofr_cod) {
    $ofertaDAO = new OfertaDAO();
    return $ofertaDAO->remove($ofr_cod);
  }

  public function search ($id) {
    $ofertaDAO = new OfertaDAO();
    return $ofertaDAO->search();
  }

  public function searchAll () {
    $ofertaDAO = new OfertaDAO();
    return $ofertaDAO->searchAll();
  }

}

?>