<?php

	// @arquivo = /dao/DisciplinaDAO.php
	// MVC = controller
	// objeto = Disciplina
	
	require_once($_SERVER['DOCUMENT_ROOT'] . 'model/Disciplina.class.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/BD.class.php');
	
	class DisciplinaDAO {
		
		public function register (Disciplina $disciplina){
		
			try {
				$dbh = Connection::connect();
				
				$sql = "INSERT INTO tab_dcp (dcp_cod, dcp_nom) VALUES (NULL, ?)";
				
				$register = $dbh->prepare($sql);
				$register->bindValue(1, $disciplina->__get("dcp_nom"));
				$register->execute();
				
				return 1;				
			} catch (Exception $e){
				//echo "Failed: ". $e->getMessage();
			}
		}
		
		public function update (Disciplina $disciplina){
			
			try {
				$dbh = Connection::connect();
				
				$sql = "UPDATE tab_dcp
						SET	    dcp_nom = ?
						WHERE   dcp_cod = ?";
				
				$update = $dbh->prepare($sql);
				$update->bindValue(1, $disciplina->__get("dcp_nom"));
				$update->bindValue(2, $disciplina->__get("dcp_cod"));
				$update->execute();
				
				return 1;				
			} catch (Exception $e) {
				//die("Unable to connect: " . $e->getMessage());
			}
			
			return 0;
		}
		
		public funtion remove ($dcp_cod){
			
			try {
				$dbh = Connection::connect();
			
				$sql = "DELETE FROM tab_dcp WHERE dcp_cod = ?";
			
				$remove = $dbh->prepare($sql);
				$remove->bindValue(1, dcp_cod);
				$remove->execute();
				
				return 1;
			} catch (Exception $e){
				//echo "Failed: "  . $e->getMessage();
			}
			
			return 0;
		}
		
		public funtion search($id){
			
			try {
				$dbh = Connection::connect();
				
				$sql = "SELECT * FROM tab_dcp WHERE dcp_cod = ?";
				
				$search = $dbh->prepare($sql);
				$search->bindValue(1, $id);
				$search->execute();
				
				$dcp = search->fetch(PDO::FETCH_ASSOC);
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
				
				$sql = "SELECT * FROM tab_dcp";
				
				$search = dbh->prepare($sql);
				$search->execute();
				
				while ($dcp = $search->fetch(PDO::FETCH_ASSOC)){
					$aux = new Disciplina();
					$axu->setAll($dcp["dcp_cod"], $dcp["dcp_nom"]);
					$prfs[] = $aux;
				}
				
				return $prfs;
				
			} catch(Exception $e){
				//die("Unable to connect: " . $e->getMessage());
			}
			
			return 0;
			
		}
		
		
	}
?>