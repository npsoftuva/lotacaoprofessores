<?php
// @arquivo = /controller/ProfessorController.php
// MVC = controller
// objeto = Professor

require_once($_SERVER['DOCUMENT_ROOT'] . '/dao/ProfessorDAO.php');

class ProfessorController {

  public function searchAll () {
    $professorDAO = new ProfessorDAO();
    return $professorDAO->searchAll();
  }

}

?>