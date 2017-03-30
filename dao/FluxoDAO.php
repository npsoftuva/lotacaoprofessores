<?php

 // @arquivo = /dao/FluxoDAO.php
 // MVC = controller
 // objeto = Fluxo
	
  require_once('../model/Fluxo.class.php');
  require_once('../lib/BD.class.php');
	
  class FluxoDAO {
    public function register (Fluxo $fluxo){
		
      try {
        $dbh = Connection::connect();
				
        $sql = "INSERT INTO tab_flx (flx_cod, flx_trn, flx_sem) VALUES (?, ?, ?)";
				
        $register = $dbh->prepare($sql);
        $register->bindValue(1, $fluxo->__get("flx_cod"));
        $register->bindValue(2, $fluxo->__get("flx_trn"));
        $register->bindValue(3, $fluxo->__get("flx_sem"));
				
        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e){
         //echo "Failed: ". $e->getMessage();
      }
    }
		
    public function update (Fluxo $fluxo){
			
      try {
        $dbh = Connection::connect();
				
        $sql = "UPDATE tab_flx
        SET     flx_trn = ?
                flx_sem = ?
        WHERE   flx_cod = ?";
				
        $update = $dbh->prepare($sql);
        $update->bindValue(1, $fluxo->__get("flx_trn"));        
        $update->bindValue(2, $fluxo->__get("flx_sem"));
        $update->bindValue(3, $fluxo->__get("flx_cod"));

        if ($update->execute())
          return 1;
        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }
			
      return 0;
    }
		
    public function remove ($flx_cod){
			
      try {
        $dbh = Connection::connect();
			
        $sql = "DELETE FROM tab_flx WHERE flx_cod = ?";
			
        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $flx_cod);
				
        if ($remove->execute())
          return 1;
        return 0;
      } catch (Exception $e){
        //echo "Failed: "  . $e->getMessage();
      }
			
      return 0;
    }
		
    public function search($flx_cod){
			
      try {
        $dbh = Connection::connect();
				
          $sql = "SELECT * FROM tab_flx WHERE flx_cod = ?";
				
          $search = $dbh->prepare($sql);
          $search->bindValue(1, $flx_cod);
          $search->execute();
				
          $flx = $search->fetch(PDO::FETCH_ASSOC);
          $aux = new Fluxo();
          $aux = setAll($flx["flx_cod"],$flx["flx_trn"], $flx["flx_sem"]);
				
          return aux;
				
      } catch(Exception $e){
         //die("Unable to connect: " . $e->getMessage());
      }
			
      return 0;
    }
		
    public function searchAll(){
			
      try {
        $dbh = Connection::connect();
				
        $sql = "SELECT * FROM tab_flx ORDER BY flx_cod";
				
        $search = $dbh->prepare($sql);
        $search->execute();
				
        while ($flx = $search->fetch(PDO::FETCH_ASSOC)){
          $aux = new Fluxo();
          $aux->setAll($flx["flx_cod"], $flx["flx_trn"], $flx["flx_sem"]);
          $flxs[] = $aux;
        }
				
        return $flxs;
				
      } catch(Exception $e){
        //die("Unable to connect: " . $e->getMessage());
      }
			
      return 0;		
    }	
  }
?>
