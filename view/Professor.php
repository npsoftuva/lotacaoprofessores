<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/ProfessorController.php');

  // listar Professor
  $professorController = new ProfessorController();
  $professores = $professorController->searchAll();

  foreach ($professores as $professor) {
    var_dump($professor);
    echo "<br>";
  }

?>
