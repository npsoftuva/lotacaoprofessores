<?php
// @arquivo = /controller/FluxoController.php
// MVC = controller
// objeto = Fluxo

require_once('../dao/FluxoDAO.php');

class FluxoController {

    public function register (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->register($fluxo);
    }

    public function update (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->update($fluxo);
    }

    public function remove ($flx_cod){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->remove($flx_cod);
    }

    public function search (){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->search();
    }

    public function searchAll (){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->searchAll();
    }
  }
?>
