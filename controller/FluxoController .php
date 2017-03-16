<?php
// @arquivo = /controller/FluxoController.php
// MVC = controller
// objeto = Fluxo

require_once($_SERVER['DOCUMENT_ROOT'] . 'dao/FluxoDAO.php');

class FluxoController {
    
    public function register (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->register($fluxo);
    }
    
    public function update (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->update($fluxo);
    }
    
    public function remove (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->remove($flx_cod);
    }
    
    public function search (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->register($fluxo);
    }
    
    public function searchAll (Fluxo $fluxo){
        $fluxoDAO = new FluxoDAO();
        return $fluxoDAO->register();
    }

?>