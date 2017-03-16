<?php
// @arquivo = /controller/ProfessorController.php
// MVC = controller
// objeto = Professor

require_once('../dao/ProfessorDAO.php');

class ProfessorController {

  public function register (Professor $professor) {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->register($professor);
  }

  public function update (Professor $professor) {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->update($professor);
  }

  public function remove ($prf_cod) {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->remove($prf_cod);
  }

  public function search () {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->search();
  }

  public function searchAll () {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->searchAll();
  }

}

?>