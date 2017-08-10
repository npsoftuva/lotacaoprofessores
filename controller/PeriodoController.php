<?php
// @arquivo = /controller/PeriodoDAO.php
// MVC = controller
// objeto = Periodo

require_once('../dao/PeriodoDAO.php');
require_once('../dao/CalendarioDAO.php');
require_once('../lib/utils.php');

class PeriodoController {

  public function register (Periodo $periodo) {

    $periodoDAO = new PeriodoDAO();
    
    $prdIni = $periodo->__get("prd_ini")->__get("cld_dta");
    $prdFim = $periodo->__get("prd_fim")->__get("cld_dta");

    $dateIniString = str_replace("/", "-", $prdIni);
    $dateFimString = str_replace("/", "-", $prdFim);
   
    $periodo->__get("prd_ini")->__set("cld_dta", date('Y-m-d', strtotime($dateIniString)));
    $periodo->__get("prd_fim")->__set("cld_dta", date('Y-m-d', strtotime($dateFimString)));

    return $periodoDAO->register($periodo);
  }

  public function update (Periodo $periodo) {
    $periodoDAO = new PeriodoDAO();
    
    $periodo->__get("prd_ini")->__set("cld_dta", date('Y-d-m', strtotime($periodo->__get("prd_ini")->__get("cld_dta"))));
    $periodo->__get("prd_fim")->__set("cld_dta", date('Y-d-m', strtotime($periodo->__get("prd_fim")->__get("cld_dta"))));
    if ($periodo->__get("prd_ini")->__get("cld_dta") > $periodo->__get("prd_fim")->__get("cld_dta"))
      return 0;

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
    if (isset($periodos))
    foreach ($periodos as $periodo) {
      $periodo->__get("prd_ini")->__set("cld_dta", date('d/m/Y', strtotime($periodo->__get("prd_ini")->__get("cld_dta"))));
      $periodo->__get("prd_fim")->__set("cld_dta", date('d/m/Y', strtotime($periodo->__get("prd_fim")->__get("cld_dta"))));
    }
    return $periodos;
  }
  
  public function searchLastCod() {
    $periodoDAO = new PeriodoDAO();
    return $periodoDAO->searchLastCod();
  }
  
}
?>