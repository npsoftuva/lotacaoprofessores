<?php
// @arquivo = /controller/DisciplinaController.php
// MVC = controller
// objeto = Disciplina

require_once($_SERVER['DOCUMENT_ROOT'] . 'dao/DisciplinaDAO.php');

class DisciplinaController {
    
    public function register (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->register($disciplina);
    }
    
    public function update (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->update($disciplina);
    }
    
    public function remove (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->remove($dcp_cod);
    }
    
    public function search (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->search($disciplina);
    }
    
    public function searchAll (Disciplina $disciplina){
        $disciplinaDAO = new DisciplinaDAO();
        return $disciplinaDAO->register();
    }
}

?>