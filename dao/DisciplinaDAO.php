<?php

// @arquivo = /dao/DisciplinaDAO.php
// MVC = controller
// objeto = Disciplina
	
  require_once('../model/Disciplina.class.php');
  require_once('../lib/BD.class.php');
	
  class DisciplinaDAO {
	
    public function register (Disciplina $disciplina){

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_dcp (dcp_nom) VALUES (?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, strtoupper($disciplina->__get("dcp_nom")));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e){
          //echo "Failed: ". $e->getMessage();
      }
    }
		
    public function update (Disciplina $disciplina){
			
      try {
        $dbh = Connection::connect();
				
        $sql = "UPDATE tab_dcp
        SET     dcp_nom = ?
        WHERE   dcp_cod = ?";
				
        $update = $dbh->prepare($sql);
        $update->bindValue(1, strtoupper($disciplina->__get("dcp_nom")));
        $update->bindValue(2, $disciplina->__get("dcp_cod"));
        if ($update->execute())
          return 1;
        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }
			
      return 0;
    }
		
    public function remove ($dcp_cod){
			
      try {
        $dbh = Connection::connect();
			
        $sql = "DELETE FROM tab_dcp WHERE dcp_cod = ?";
			
        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $dcp_cod);
				
        if ($remove->execute())
          return 1;

        return 0;
      } catch (Exception $e){
        //echo "Failed: "  . $e->getMessage();
      }
			
      return 0;
    }
		
    public function search($dcp_cod){
			
      try {
        $dbh = Connection::connect();
				
        $sql = "SELECT * FROM tab_dcp WHERE dcp_cod = ?";
				
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $dcp_cod);
        $search->execute();
				
        $dcp = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Disciplina(); 
        $aux = setAll($dcp["dcp_cod"],$dcp["dcp_nom"]);
				
        return aux;
				
      } catch(Exception $e){
        //die("Unable to connect: " . $e->getMessage());
      }
			
      return 0;
    }
		
    public function searchAll(){
			
      try {
        $dbh = Connection::connect();
				
        $sql = "SELECT * FROM tab_dcp ORDER BY dcp_nom";
				
        $search = $dbh->prepare($sql);
        if (!$search->execute())
          return 0;
				
        while ($dcp = $search->fetch(PDO::FETCH_ASSOC)){
          $aux = new Disciplina();
          $aux->setAll($dcp["dcp_cod"], $dcp["dcp_nom"]);
          $dcps[] = $aux;
        }
				
        return $dcps;
				
        } catch(Exception $e){
          //die("Unable to connect: " . $e->getMessage());
        }
			
        return 0;			
      }		
    }
?>
