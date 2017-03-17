<?php
// @arquivo = /controller/DisciplinaController.php
// MVC = controller
// objeto = Disciplina

require_once('../dao/DisciplinaDAO.php');

class DisciplinaController {

    public function register (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->register($disciplina);
    }
    
    public function update (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->update($disciplina);
    }
    
    public function remove ($dcp_cod){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->remove($dcp_cod);
    }
    
    public function search () {
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->search();
    }
    
    public function searchAll () {
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->searchAll();
    }
}

?>
