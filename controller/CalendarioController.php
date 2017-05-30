<?php
// @arquivo = /controller/CalendarioController.php
// MVC = controller
// objeto = Calendario

require_once('../dao/CalendarioDAO.php');

class CalendarioController {

  public function register (Calendario $calendario) {
    $calendarioDAO = new CalendarioDAO();
    return $calendarioDAO->register($calendario);
  }

  public function update (Calendario $calendario) {
    $calendarioDAO = new CalendarioDAO();
    return $calendarioDAO->update($calendario);
  }

  public function remove ($cld_dta) {
    $calendarioDAO = new CalendarioDAO();
    return $calendarioDAO->remove($cld_dta);
  }

  public function search ($cld_dta) {
    $calendarioDAO = new CalendarioDAO();
    return $calendarioDAO->search($cld_dta);
  }

  public function searchAll () {
    $calendarioDAO = new CalendarioDAO();
    return $calendarioDAO->searchAll();
  }

  public function searchMinDate() {
    $calendarioDAO = new CalendarioDAO();
    return $calendarioDAO->searchMinDate();
  }
}

?>
