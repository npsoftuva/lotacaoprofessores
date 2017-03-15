<?php
// @arquivo = /controller/ProfessorController.php
// MVC = controller
// objeto = Professor

require_once($_SERVER['DOCUMENT_ROOT'] . '/dao/ProfessorDAO.php');

class ProfessorController {

  public function register (Professor $professor) {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->register($professor);
  }

  public function remove ($prf_cod) {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->remove($prf_cod);
  }

  public function searchAll () {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->searchAll();
  }

}

?>