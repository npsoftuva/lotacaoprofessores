<?php
// @arquivo = /controller/PeriodoDAO.php
// MVC = controller
// objeto = Periodo

require_once('../dao/PeriodoDAO.php');

class PeriodoController {

  public function register (Periodo $periodo) {
    $periodoDAO = new PeriodoDAO();
    return $periodoDAO->register($periodo);
  }

  public function update (Periodo $periodo) {
    if ($periodo->__get("prd_ini") > $periodo->__get("prd_fim"))
      return 0;
    $periodoDAO = new PeriodoDAO();
    return $periodoDAO->update($periodo);
  }

  public function remove ($prd_cod) {
    $periodoDAO = new PeriodoDAO();
    return $periodoDAO->remove($prd_cod);
  }

  public function search ($prd_cod) {
    $periodoDAO = new PeriodoDAO();
    return $periodoDAO->search($prd_cod);
  }

  public function searchAll () {
    $periodoDAO = new PeriodoDAO();
    $periodos = $periodoDAO->searchAll();
    foreach ($periodos as $periodo) {
      $periodo->__get("prd_ini")->__set("cld_dta", date('d/m/Y', strtotime($periodo->__get("prd_ini")->__get("cld_dta"))));
      $periodo->__get("prd_fim")->__set("cld_dta", date('d/m/Y', strtotime($periodo->__get("prd_fim")->__get("cld_dta"))));
    }
    return $periodos;
  }

}

?>